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
     * @var array $variables
     */
    private array $variables;

    /**
     * Get identity variable.
     *
     * @return string
     */
    public function getIdentity() : string
    {
        return $this->variables["identity"];
    }

    /**
     * Set identity variable.
     *
     * @param string $identity
     * @return PhpTcKimlik
     */
    public function setIdentity(string $identity) : PhpTcKimlik
    {
        $this->variables["identity"] = $identity;
        return $this;
    }

    /**
     * Get name variable.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->variables["name"];
    }

    /**
     * Set name variable.
     *
     * @param string $name
     * @return PhpTcKimlik
     */
    public function setName(string $name) : PhpTcKimlik
    {
        $this->variables["name"] = $name;
        return $this;
    }

    /**
     * Get family name variable.
     *
     * @return string
     */
    public function getFamilyName() : string
    {
        return $this->variables["family_name"];
    }

    /**
     * Set family name variable.
     *
     * @param string $family_name
     * @return PhpTcKimlik
     */
    public function setFamilyName(string $family_name) : PhpTcKimlik
    {
        $this->variables["family_name"] = $family_name;
        return $this;
    }

    /**
     * Get year variable.
     *
     * @return int
     */
    public function getYear() : int
    {
        return $this->variables["year"];
    }

    /**
     * Set year variable.
     *
     * @param $year
     * @return PhpTcKimlik
     */
    public function setYear($year) : PhpTcKimlik
    {
        $this->variables["year"] = (int) $year;
        return $this;
    }

    /**
     * PhpTcKimlik constructor.
     *
     * @param string|null $identity
     * @param string|null $name
     * @param string|null $family_name
     * @param int|null $year
     */
    public function __construct(string $identity = null, string $name = null, string $family_name = null, int $year = null)
    {
        $this->variables = [
            "identity"      => $identity == null ? "" : $identity,
            "name"          => $name == null ? "" : $name,
            "family_name"   => $family_name == null ? "" : $family_name,
            "year"          => $year == null ? (int) date("Y") : $year,
        ];
    }

    /**
     * Validate identity.
     *
     * @param bool $nvi
     * @return bool
     */
    public function check(bool $nvi = true) : bool
    {
        if (!$nvi) {
            if (!self::verifyIdentity($this->getIdentity()) || !self::verifyName($this->getName()) || !self::verifyName($this->getFamilyName()) || !self::verifyYear($this->getYear())) {
                return false;
            }

            return true;
        }

        return self::validate($this->getIdentity(), $this->getName(), $this->getFamilyName(), $this->getYear());
    }

    /**
     * Create new PhpTcKimlik object.
     *
     * @param string|null $identity
     * @param string|null $name
     * @param string|null $family_name
     * @param int|null $year
     * @return PhpTcKimlik
     */
    public static function validator(string $identity = null, string $name = null, string $family_name = null, int $year = null) : PhpTcKimlik
    {
        return new PhpTcKimlik(...func_get_args());
    }

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
