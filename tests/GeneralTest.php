<?php

namespace IsaEken\PhpTcKimlik\Test;


use DateTime;
use IsaEken\PhpTcKimlik\Helpers;
use IsaEken\PhpTcKimlik\NviRequest;
use IsaEken\PhpTcKimlik\PhpTcKimlik;
use PHPUnit\Framework\TestCase;

class GeneralTest extends TestCase
{
    public function testHelpers()
    {
        $this->assertTrue(Helpers::verifyIdentity("12345678910"));
        $this->assertFalse(Helpers::verifyIdentity("09876543210"));

        $this->assertTrue(Helpers::verifyName("İsa"));
        $this->assertTrue(Helpers::verifyName("Eken"));
        $this->assertTrue(Helpers::verifyName("İsa Eken"));
        $this->assertFalse(Helpers::verifyName("^!İsa \"'-- Eken"));

        $this->assertTrue(Helpers::verifyYear(date("Y")));
        $this->assertTrue(Helpers::verifyYear(1881));
        $this->assertTrue(Helpers::verifyYear("2000"));
        $this->assertTrue(Helpers::verifyYear(202));
        $this->assertFalse(Helpers::verifyYear(-2020));
        $this->assertFalse(Helpers::verifyYear("-2020"));

        $this->assertEquals("İSA", Helpers::upper("isa"));
        $this->assertEquals("isa", Helpers::lower("İSA"));
    }

    public function testNviRequest()
    {
        $request = new NviRequest;
        $request->setData("TCKimlikNo", "12345678910");
        $request->setData("Ad", "İsa");
        $request->setData("Soyad", "Eken");
        $request->setData("DogumYili", "2002");

        $xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
<soap:Body>
<TCKimlikNoDogrula xmlns="http://tckimlik.nvi.gov.tr/WS">
<TCKimlikNo>12345678910</TCKimlikNo>
<Ad>İsa</Ad>
<Soyad>Eken</Soyad>
<DogumYili>2002</DogumYili>
</TCKimlikNoDogrula>
</soap:Body>
</soap:Envelope>
XML;

        $this->assertEquals($xml, (new NviRequest())->setData("TCKimlikNoDogrula", $request, ["xmlns" => "http://tckimlik.nvi.gov.tr/WS"])->__toXml());
    }

    public function testValidators()
    {
        $identityCard = new PhpTcKimlik;
        $identityCard->setIdentityNumber("12345678910");
        $identityCard->setGivenName("İsa");
        $identityCard->setSurname("Eken");
        $identityCard->setBirthDate(new DateTime("10.04.2002"));

        $this->assertFalse($identityCard->validateIdentityNumber());
        $this->assertFalse($identityCard->validateForeignIdentityNumber());
    }
}
