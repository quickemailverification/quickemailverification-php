<?php

namespace QuickEmailVerification;

use QuickEmailVerification\HttpClient\HttpClient;

class Client
{
    private $httpClient;

    public function __construct($auth = array(), array $options = array())
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
