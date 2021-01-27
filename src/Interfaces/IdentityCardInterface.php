<?php


namespace IsaEken\PhpTcKimlik\Interfaces;


use DateTimeInterface;

/**
 * Interface IdentityCardInterface
 * @package IsaEken\PhpTcKimlik\Interfaces
 */
interface IdentityCardInterface
{
    /**
     * Get identity number.
     *
     * @return string
     */
    public function getIdentityNumber() : string;

    /**
     * Set identity number.
     *
     * @param string $identity
     * @return IdentityCardInterface
     */
    public function setIdentityNumber(string $identity) : IdentityCardInterface;

    /**
     * Get surname.
     *
     * @return string
     */
    public function getSurname() : string;

    /**
     * Set surname.
     *
     * @param string $surname
     * @return IdentityCardInterface
     */
    public function setSurname(string $surname) : IdentityCardInterface;

    /**
     * Get given name.
     *
     * @return string
     */
    public function getGivenName() : string;

    /**
     * Set given name.
     *
     * @param string $name
     * @return IdentityCardInterface
     */
    public function setGivenName(string $name) : IdentityCardInterface;

    /**
     * Get date of birth.
     *
     * @return DateTimeInterface
     */
    public function getBirthDate() : DateTimeInterface;

    /**
     * Set date of birth.
     *
     * @param DateTimeInterface $date
     * @return IdentityCardInterface
     */
    public function setBirthDate(DateTimeInterface $date) : IdentityCardInterface;

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender() : string;

    /**
     * Set gender.
     *
     * @param string $gender
     * @return IdentityCardInterface
     */
    public function setGender(string $gender) : IdentityCardInterface;

    /**
     * Get document number.
     *
     * @return string
     */
    public function getDocumentNumber() : string;

    /**
     * Set document number.
     *
     * @param string $documentNumber
     * @return IdentityCardInterface
     */
    public function setDocumentNumber(string $documentNumber) : IdentityCardInterface;

    /**
     * Get nationality.
     *
     * @return string
     */
    public function getNationality() : string;

    /**
     * Set nationality.
     *
     * @param string $nationality
     * @return IdentityCardInterface
     */
    public function setNationality(string $nationality) : IdentityCardInterface;

    /**
     * Get valid until.
     *
     * @return DateTimeInterface
     */
    public function getValidUntil() : DateTimeInterface;

    /**
     * Set valid until.
     *
     * @param DateTimeInterface $date
     * @return IdentityCardInterface
     */
    public function setValidUntil(DateTimeInterface $date) : IdentityCardInterface;

    /**
     * Get mother name.
     *
     * @return string
     */
    public function getMotherName() : string;

    /**
     * Set mother name.
     *
     * @param string $name
     * @return IdentityCardInterface
     */
    public function setMotherName(string $name) : IdentityCardInterface;

    /**
     * Get father name.
     *
     * @return string
     */
    public function getFatherName() : string;

    /**
     * Set father name.
     *
     * @param string $name
     * @return IdentityCardInterface
     */
    public function setFatherName(string $name) : IdentityCardInterface;

    /**
     * Get issued by.
     *
     * @return string
     */
    public function getIssuedBy() : string;

    /**
     * Set issued by.
     *
     * @param string $issuedBy
     * @return IdentityCardInterface
     */
    public function setIssuedBy(string $issuedBy) : IdentityCardInterface;
}
