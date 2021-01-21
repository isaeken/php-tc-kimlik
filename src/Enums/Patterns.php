<?php


namespace IsaEken\PhpTcKimlik\Enums;


/**
 * Class Patterns
 *
 * @package IsaEken\PhpTcKimlik\Enums
 */
abstract class Patterns
{
    const Identity = "/^[1-9]{1}[0-9]{9}[02468]{1}$/";
    const Name = "/^([a-zA-ZÇŞĞÜÖİçşğüöı ]+)$/";
    const Year = "/^\d{4}$/";
}
