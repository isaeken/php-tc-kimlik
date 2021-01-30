<?php


namespace IsaEken\PhpTcKimlik\Rules;


use Illuminate\Contracts\Validation\Rule;
use IsaEken\PhpTcKimlik\Helpers;

class RealName implements Rule
{
    /**
     * @var bool $required
     */
    protected $required;

    /**
     * @var string $attribute
     */
    protected $attribute;

    /**
     * IdentityNumber constructor.
     * @param bool $required
     */
    public function __construct(bool $required = true)
    {
        $this->required = $required;
    }

    /**
     * @return IdentityNumber
     */
    public function nullable() : self
    {
        $this->required = false;

        return $this;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) : bool
    {
        $this->attribute = $attribute;

        if ($this->required && (!is_string($value) || is_null($value))) {
            return false;
        }

        return Helpers::verifyName($value);
    }

    /**
     * @return string
     */
    public function message() : string
    {
        return __("Please enter real name.");
    }
}
