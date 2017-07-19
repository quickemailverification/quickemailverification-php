<?php

namespace QuickEmailVerification;

use QuickEmailVerification\HttpClient\HttpClient;

class Client implements ClientInterface
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param string $auth
     * @param array $options
     */
    public function __construct($auth = '', array $options = [])
    {
        $this->httpClient = new HttpClient($auth, $options);
    }

    /**
     * QuickEmailVerification Class for email verification
    */
    public function quickemailverification()
    {
        return new Api\Quickemailverification($this->httpClient);
    }
}
