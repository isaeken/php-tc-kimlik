<?php


namespace IsaEken\PhpTcKimlik\Traits;


use DateTime;
use DateTimeInterface;
use IsaEken\PhpTcKimlik\Interfaces\IdentityCardInterface;
use IsaEken\PhpTcKimlik\PhpTcKimlik;

trait IdentityCardTrait
{
    /**
     * @var array $variables
     */
    private array $variables = [
        "identity" => "",
        "surname" => "",
        "given_name" => "",
        "birth_date" => null,
        "gender" => "",
        "document_number" => "",
        "nationality" => "T.C./TUR",
        "valid_until" => null,
        "mother_name" => "",
        "father_name" => "",
        "issued_by" => "",
    ];

    /**
     * Get identity number.
     *
     * @return string
     */
    public function getIdentityNumber() : string
    {
        return $this->variables["identity"];
    }

    /**
     * Set identity number.
     *
     * @param string $identity
     * @return IdentityCardInterface
     */
    public function setIdentityNumber(string $identity) : IdentityCardInterface
    {
        $this->variables["identity"] = $identity;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get surname.
     *
     * @return string
     */
    public function getSurname() : string
    {
        return $this->variables["surname"];
    }

    /**
     * Set surname.
     *
     * @param string $surname
     * @return IdentityCardInterface
     */
    public function setSurname(string $surname) : IdentityCardInterface
    {
        $this->variables["surname"] = $surname;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get given name.
     *
     * @return string
     */
    public function getGivenName() : string
    {
        return $this->variables["given_name"];
    }

    /**
     * Set given name.
     *
     * @param string $name
     * @return IdentityCardInterface
     */
    public function setGivenName(string $name) : IdentityCardInterface
    {
        $this->variables["given_name"] = $name;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get date of birth.
     *
     * @return DateTimeInterface
     */
    public function getBirthDate() : DateTimeInterface
    {
        if (!isset($this->variables["birth_date"]) || $this->variables["birth_date"] == null) {
            return new DateTime;
        }

        return $this->variables["birth_date"];
    }

    /**
     * Set date of birth.
     *
     * @param DateTimeInterface $date
     * @return IdentityCardInterface
     */
    public function setBirthDate(DateTimeInterface $date) : IdentityCardInterface
    {
        $this->variables["birth_date"] = $date;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender() : string
    {
        return $this->variables["gender"];
    }

    /**
     * Set gender.
     *
     * @param string $gender
     * @return IdentityCardInterface
     */
    public function setGender(string $gender) : IdentityCardInterface
    {
        $this->variables["gender"] = $gender;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get document number.
     *
     * @return string
     */
    public function getDocumentNumber() : string
    {
        return $this->variables["document_number"];
    }

    /**
     * Set document number.
     *
     * @param string $documentNumber
     * @return IdentityCardInterface
     */
    public function setDocumentNumber(string $documentNumber) : IdentityCardInterface
    {
        $this->variables["document_number"] = $documentNumber;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get nationality.
     *
     * @return string
     */
    public function getNationality() : string
    {
        return $this->variables["nationality"];
    }

    /**
     * Set nationality.
     *
     * @param string $nationality
     * @return IdentityCardInterface
     */
    public function setNationality(string $nationality) : IdentityCardInterface
    {
        $this->variables["nationality"] = $nationality;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get valid until.
     *
     * @return DateTimeInterface
     */
    public function getValidUntil() : DateTimeInterface
    {
        if (!isset($this->variables["valid_until"]) || $this->variables["valid_until"] == null) {
            return new DateTime;
        }

        return $this->variables["valid_until"];
    }

    /**
     * Set valid until.
     *
     * @param DateTimeInterface $date
     * @return IdentityCardInterface
     */
    public function setValidUntil(DateTimeInterface $date) : IdentityCardInterface
    {
        $this->variables["valid_until"] = $date;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get mother name.
     *
     * @return string
     */
    public function getMotherName() : string
    {
        return $this->variables["mother_name"];
    }

    /**
     * Set mother name.
     *
     * @param string $name
     * @return IdentityCardInterface
     */
    public function setMotherName(string $name) : IdentityCardInterface
    {
        $this->variables["mother_name"] = $name;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get father name.
     *
     * @return string
     */
    public function getFatherName() : string
    {
        return $this->variables["father_name"];
    }

    /**
     * Set father name.
     *
     * @param string $name
     * @return IdentityCardInterface
     */
    public function setFatherName(string $name) : IdentityCardInterface
    {
        $this->variables["father_name"] = $name;

        /** @var PhpTcKimlik $this */
        return $this;
    }

    /**
     * Get issued by.
     *
     * @return string
     */
    public function getIssuedBy() : string
    {
        return $this->variables["issued_by"];
    }

    /**
     * Set issued by.
     *
     * @param string $issuedBy
     * @return IdentityCardInterface
     */
    public function setIssuedBy(string $issuedBy) : IdentityCardInterface
    {
        $this->variables["issued_by"] = $issuedBy;

        /** @var PhpTcKimlik $this */
        return $this;
    }
}
