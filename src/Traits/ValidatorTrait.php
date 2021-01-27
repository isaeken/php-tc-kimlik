<?php


namespace IsaEken\PhpTcKimlik\Traits;


use DateTimeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use IsaEken\PhpTcKimlik\Helpers;
use IsaEken\PhpTcKimlik\NviRequest;

/**
 * Trait ValidatorTrait
 * @package IsaEken\PhpTcKimlik\Traits
 * @property Client $client
 */
trait ValidatorTrait
{
    /**
     * Validate identity number using NVI.
     *
     * @return bool
     */
    public function validateIdentityNumber() : bool
    {
        $identity = $this->getIdentityNumber();
        $given_name = $this->getGivenName();
        $surname = $this->getSurname();
        $birth_year = $this->getBirthDate()->format("Y");

        if (!Helpers::verifyIdentity($identity)) {
            return false;
        }

        if (!Helpers::verifyName($given_name) || !Helpers::verifyName($surname)) {
            return false;
        }

        if (!Helpers::verifyYear($birth_year)) {
            return false;
        }

        $body = new NviRequest;
        $request = new NviRequest;

        $body->setData("TCKimlikNo", $identity);
        $body->setData("Ad", $given_name);
        $body->setData("Soyad", $surname);
        $body->setData("DogumYili", $birth_year);
        $request->setData("TCKimlikNoDogrula", $body, [ "xmlns" => "http://tckimlik.nvi.gov.tr/WS" ]);

        try {

            $response = $this->client->request("POST", "https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx", [
                "headers" => [
                    "POST" => "/Service/KPSPublic.asmx HTTP/1.1",
                    "Host" => "tckimlik.nvi.gov.tr",
                    "Content-Type" => "text/xml; charset=utf-8",
                    "Content-Length" => strlen($request->__toXml()),
                ],
                "body" => $request->__toXml(),
            ]);

            if ($response->getStatusCode() === 200 && strip_tags($response->getBody()->getContents()) == "true") {
                return true;
            }

        } catch (GuzzleException $exception) {
            return false;
        }

        return false;
    }

    /**
     * Validate foreign identity number using NVI.
     *
     * @return bool
     */
    public function validateForeignIdentityNumber() : bool
    {
        $identity = $this->getIdentityNumber();
        $given_name = $this->getGivenName();
        $surname = $this->getSurname();
        $birth_date = $this->getBirthDate();

        if (!Helpers::verifyName($given_name) || !Helpers::verifyName($surname)) {
            return false;
        }

        $request = (new NviRequest)
            ->setData("YabanciKimlikNoDogrula", (new NviRequest())
                ->setData("KimlikNo", $identity)
                ->setData("Ad", $given_name)
                ->setData("Soyad", $surname)
                ->setData("DogumGun", $birth_date->format("d"))
                ->setData("DogumAy", $birth_date->format("m"))
                ->setData("DogumYil", $birth_date->format("Y")),
                [ "xmlns" => "http://tckimlik.nvi.gov.tr/WS" ]
            )->__toXml();

        try {
            $response = $this->client->request("POST", "https://tckimlik.nvi.gov.tr/Service/KPSPublicYabanciDogrula.asmx", [
                "headers" => [
                    "POST" => "/Service/KPSPublicYabanciDogrula.asmx HTTP/1.1",
                    "Host" => "tckimlik.nvi.gov.tr",
                    "Content-Type" => "text/xml; charset=utf-8",
                    "Content-Length" => strlen($request),
                ],
                "body" => $request,
            ]);

            if ($response->getStatusCode() === 200 && strip_tags($response->getBody()->getContents()) == "true") {
                return true;
            }

        } catch (GuzzleException $exception) {
            return false;
        }

        return false;
    }

    /**
     * Validate Turkey identity card.
     *
     * @return bool
     */
    public function validateIdentityCard() : bool
    {
        $identityNumber = $this->getIdentityNumber();
        $given_name = $this->getGivenName();
        $surname = $this->getSurname();
        $birth_date = $this->getBirthDate();
        $document_number = $this->getDocumentNumber();

        if (!Helpers::verifyIdentity($identityNumber) || !Helpers::verifyName($given_name) || !Helpers::verifyName($surname)) {
            return false;
        }

        $request = (new NviRequest)
            ->setData("KisiVeCuzdanDogrula", (new NviRequest())
                ->setData("TCKimlikNo", $identityNumber)
                ->setData("Ad", $given_name)
                ->setData("Soyad", $surname)
                ->setData("DogumGun", $birth_date->format("d"))
                ->setData("DogumAy", $birth_date->format("m"))
                ->setData("DogumYil", $birth_date->format("Y"))
                ->setData("TCKKSeriNo", Helpers::upper($document_number)),
                [ "xmlns" => "http://tckimlik.nvi.gov.tr/WS" ]
            )->__toXml();

        try {
            $response = $this->client->request("POST", "https://tckimlik.nvi.gov.tr/Service/KPSPublicV2.asmx", [
                "headers" => [
                    "POST" => "/Service/KPSPublicV2.asmx HTTP/1.1",
                    "Host" => "tckimlik.nvi.gov.tr",
                    "Content-Type" => "text/xml; charset=utf-8",
                    "Content-Length" => strlen($request),
                ],
                "body" => $request,
            ]);

            if ($response->getStatusCode() === 200 && strip_tags($response->getBody()->getContents()) == "true") {
                return true;
            }

        } catch (GuzzleException $exception) {
            return false;
        }

        return false;
    }
}
