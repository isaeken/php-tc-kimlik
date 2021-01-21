<?php


namespace IsaEken\PhpTcKimlik;


use IsaEken\PhpTcKimlik\Enums\Patterns;
use Spatie\Regex\Regex;

/**
 * Class Helpers
 *
 * @package IsaEken\PhpTcKimlik
 */
class Helpers
{
    /**
     * Check identity is valid.
     *
     * @param string $identity
     * @return bool
     */
    public static function verifyIdentity(string $identity) : bool
    {
        return Regex::match(Patterns::Identity, $identity)->hasMatch();
    }

    /**
     * Verify name is valid.
     *
     * @param string $name
     * @return bool
     */
    public static function verifyName(string $name) : bool
    {
        return Regex::match(Patterns::Name, $name)->hasMatch();
    }

    /**
     * Verify year is valid.
     *
     * @param int|string $year
     * @param int $min
     * @param int $max
     * @return bool
     */
    public static function verifyYear($year, int $min = 0, int $max = 3000) : bool
    {
        if (is_integer($year)) {
            if ($year <= $max && $year >= $min) {
                return true;
            }
        }
        else if (is_string($year)) {
            if (Regex::match(Patterns::Year, $year)->hasMatch() === true) {
                $year = intval($year);
                if ($year <= $max && $year >= $min) {
                    return true;
                }
            }
        }

        return false;
    }
}
