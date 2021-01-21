<?php


namespace IsaEken\PhpTcKimlik;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class PhpTcKimlik
 *
 * @package IsaEken\PhpTcKimlik
 */
class PhpTcKimlik
{
    /**
     * Check identity is valid.
     *
     * @param string $identity
     * @return bool
     */
    public static function verifyIdentity(string $identity) : bool
    {
        return Helpers::verifyIdentity(...func_get_args());
    }

    /**
     * Verify name is valid.
     *
     * @param string $name
     * @return bool
     */
    public static function verifyName(string $name) : bool
    {
        return Helpers::verifyName(...func_get_args());
    }

    /**
     * Verify year is valid.
     *
     * @param int|string $year
     * @param int $min
     * @param int $max
     * @return bool
     */
    public static function verifyYear($year, int $min = 0, int $max = 0) : bool
    {
        return Helpers::verifyYear(...func_get_args());
    }

    /**
     * Validate identity using NVI
     *
     * @param string $identity
     * @param string $name
     * @param string $family_name
     * @param int|string $birth_year
     * @param array $options
     * @return bool
     */
    public static function validate(string $identity, string $name, string $family_name, $birth_year, array $options = []) : bool
    {
        if (!self::verifyIdentity($identity)) {
            return false;
        }

        if (!self::verifyName($name)) {
            return false;
        }

        if (!self::verifyName($family_name)) {
            return false;
        }

        if (!self::verifyYear($birth_year, date("Y") - 200, date("Y") + 200)) {
            return false;
        }

        $requestBody = <<<BODY
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <TCKimlikNoDogrula xmlns="http://tckimlik.nvi.gov.tr/WS">
            <TCKimlikNo>$identity</TCKimlikNo>
            <Ad>$name</Ad>
            <Soyad>$family_name</Soyad>
            <DogumYili>$birth_year</DogumYili>
        </TCKimlikNoDogrula>
    </soap:Body>
</soap:Envelope>
BODY;

        $_options = [
            "verify" => true,
            "http_errors" => false,
        ];

        foreach ($options as $key => $value) {
            $_options[$key] = $value;
        }

        $client = new Client($_options);

        try {
            $response = $client->request("POST", "https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx", [
                "headers" => [
                    "POST" => "/Service/KPSPublic.asmx HTTP/1.1",
                    "Host" => "tckimlik.nvi.gov.tr",
                    "Content-Type" => "text/xml; charset=utf-8",
                    "SOAPAction" => "\"http://tckimlik.nvi.gov.tr/WS/TCKimlikNoDogrula\"",
                    "Content-Length" => strlen($requestBody),
                ],
                "body" => $requestBody
            ]);

            if ($response->getStatusCode() === 200) {
                if (strip_tags($response->getBody()->getContents()) == "true") {
                    return true;
                }
            }

            return false;
        }
        catch (GuzzleException $exception) {
            return false;
        }
    }
}
