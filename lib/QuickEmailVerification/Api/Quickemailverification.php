<?php

namespace QuickEmailVerification\Api;

use QuickEmailVerification\HttpClient\HttpClient;

/**
 * QuickEmailVerification Class for email verification
 */
class Quickemailverification
{

    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * Verify email address and get detailed response
     *
     * '/verify?email=:email' GET
     *
     * @param $email send email address in query parameter
     */
    public function verify($email, array $options = array())
    {
        $body = (isset($options['query']) ? $options['query'] : array());

        $response = $this->client->get('/verify?email='.rawurlencode($email).'', $body, $options);

        return $response;
    }

}
