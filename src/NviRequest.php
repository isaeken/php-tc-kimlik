<?php


namespace IsaEken\PhpTcKimlik;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class NviRequest
{
    /**
     * @var array $request
     */
    public array $request = [];

    /**
     * @param string $key
     * @param $value
     * @param array $arguments
     * @return NviRequest
     */
    public function setData(string $key, $value, array $arguments = []) : NviRequest
    {
        $this->request[$key] = (object) [
            "key" => $key,
            "value" => $value,
            "arguments" => $arguments,
        ];
        return $this;
    }

    /**
     * @param string $key
     * @return object|null
     */
    public function getData(string $key) : ?object
    {
        return $this->request[$key];
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        $body = "";
        foreach ($this->request as $key => $object) {
            $body .= "<" . $object->key;

            foreach ($object->arguments as $argumentKey => $argumentValue) {
                $body .= " $argumentKey=\"$argumentValue\"";
            }

            $body .= ">";

            if ($object->value instanceof NviRequest) {
                /** @var NviRequest */
                $body .= "\r\n".$object->value->__toString();
            }
            else {
                $body .= $object->value;
            }

            $body .= "</" . $object->key . ">\r\n";
        }

        return $body;
    }

    /**
     * @return string
     */
    public function __toXml() : string
    {
        $body = $this->__toString();
        return <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
<soap:Body>
$body</soap:Body>
</soap:Envelope>
EOF;
    }
}
