<?php


namespace IsaEken\PhpTcKimlik\Traits;


use DateTimeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use IsaEken\PhpTcKimlik\NviRequest;

/**
 * Trait ValidatorTrait
 * @package IsaEken\PhpTcKimlik\Traits
 * @property Client $client
 * @method string getIdentityNumber()
 * @method string getGivenName()
 * @method string getSurname()
 * @method DateTimeInterface getBirthDate()
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
        $body = new NviRequest;
        $request = new NviRequest;

        $body->setData("TCKimlikNo", $this->getIdentityNumber());
        $body->setData("Ad", $this->getGivenName());
        $body->setData("Soyad", $this->getSurname());
        $body->setData("DogumYili", $this->getBirthDate()->format("Y"));
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
}
