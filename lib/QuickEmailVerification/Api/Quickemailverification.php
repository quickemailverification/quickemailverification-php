<?php

namespace QuickEmailVerification\Api;

use ErrorException;
use QuickEmailVerification\HttpClient\HttpClientInterface;
use QuickEmailVerification\HttpClient\Response;

class Quickemailverification implements QuickEmailVerificationInterface
{
    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Verify email address and get detailed response
     *
     * '/v1/verify?email=:email' GET
     *
     * @param string $email send email address in query parameter
     * @throws ErrorException
     */
    public function verify($email, array $options = []): Response
    {
        $body = $options['query'] ?? [];
        $body['email'] = $email;

        return $this->client->get('/v1/verify', $body, $options);
    }

    /**
     * Return predefined response for predefined email address
     *
     * '/v1/verify/sandbox?email=:email' GET
     *
     * @param string $email send email address in query parameter
     * @throws ErrorException
     */
    public function sandbox($email, array $options = []): Response
    {
        $body = $options['query'] ?? [];
        $body['email'] = $email;

        return $this->client->get('/v1/verify/sandbox', $body, $options);
    }
}
