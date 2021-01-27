<?php


namespace IsaEken\PhpTcKimlik;


use DateTimeInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use IsaEken\PhpTcKimlik\Interfaces\IdentityCardInterface;
use IsaEken\PhpTcKimlik\Traits\IdentityCardTrait;
use IsaEken\PhpTcKimlik\Traits\ValidatorTrait;

/**
 * Class PhpTcKimlik
 *
 * @package IsaEken\PhpTcKimlik
 */
class PhpTcKimlik implements IdentityCardInterface
{
    use IdentityCardTrait;
    use ValidatorTrait;

    /**
     * @var Client $client
     */
    public Client $client;

    /**
     * PhpTcKimlik constructor.
     */
    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * Check is valid identity.
     *
     * @param string $identityNumber
     * @param string $given_name
     * @param string $surname
     * @param DateTimeInterface $birth_date
     * @return bool
     */
    public static function isValidIdentity(string $identityNumber, string $given_name, string $surname, DateTimeInterface $birth_date) : bool
    {
        return (new PhpTcKimlik)
            ->setIdentityNumber($identityNumber)
            ->setGivenName($given_name)
            ->setSurname($surname)
            ->setBirthDate($birth_date)
            ->validateIdentityNumber();
    }

    /**
     * Check is valid foreign identity.
     *
     * @param string $identityNumber
     * @param string $given_name
     * @param string $surname
     * @param DateTimeInterface $birth_date
     * @return bool
     */
    public static function isValidForeignIdentity(string $identityNumber, string $given_name, string $surname, DateTimeInterface $birth_date) : bool
    {
        return (new PhpTcKimlik)
            ->setIdentityNumber($identityNumber)
            ->setGivenName($given_name)
            ->setSurname($surname)
            ->setBirthDate($birth_date)
            ->validateForeignIdentityNumber();
    }

    /**
     * Check is valid identity card.
     *
     * @param string $identityNumber
     * @param string $documentNumber
     * @param string $given_name
     * @param string $surname
     * @param DateTimeInterface $birth_date
     * @return bool
     */
    public static function isValidIdentityCard(string $identityNumber, string $documentNumber, string $given_name, string $surname, DateTimeInterface $birth_date) : bool
    {
        return (new PhpTcKimlik)
            ->setIdentityNumber($identityNumber)
            ->setDocumentNumber($documentNumber)
            ->setGivenName($given_name)
            ->setSurname($surname)
            ->setBirthDate($birth_date)
            ->validateIdentityCard();
    }
}
