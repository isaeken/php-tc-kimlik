<?php


use IsaEken\PhpTcKimlik\Helpers;
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
    }

    public function testAliases()
    {
        $this->assertTrue(PhpTcKimlik::verifyIdentity("12345678910"));
        $this->assertFalse(PhpTcKimlik::verifyIdentity("09876543210"));

        $this->assertTrue(PhpTcKimlik::verifyName("İsa"));
        $this->assertTrue(PhpTcKimlik::verifyName("Eken"));
        $this->assertTrue(PhpTcKimlik::verifyName("İsa Eken"));
        $this->assertFalse(PhpTcKimlik::verifyName("^!İsa \"'-- Eken"));

        $this->assertTrue(PhpTcKimlik::verifyYear(date("Y")));
        $this->assertTrue(PhpTcKimlik::verifyYear(1881));
        $this->assertTrue(PhpTcKimlik::verifyYear("2000"));
        $this->assertTrue(PhpTcKimlik::verifyYear(202));
        $this->assertFalse(PhpTcKimlik::verifyYear(-2020));
        $this->assertFalse(PhpTcKimlik::verifyYear("-2020"));
    }

    public function testValidation()
    {
        $this->assertFalse(PhpTcKimlik::validate("12345678910", "İsa", "Eken", "2002"));
        $this->assertFalse(PhpTcKimlik::validate("12345678910", "''''''", "Eken", "2002"));
        $this->assertFalse(PhpTcKimlik::validate("12345678910", "İsa", "'''''''", "2002"));
        $this->assertFalse(PhpTcKimlik::validate("12345678910", "İsa", "Eken", "''''''''"));
        $this->assertFalse(PhpTcKimlik::validate("00000000000", "İsa", "Eken", "2002"));
    }
}
