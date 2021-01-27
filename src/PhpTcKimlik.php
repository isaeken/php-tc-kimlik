<?php


namespace IsaEken\PhpTcKimlik;


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
}
