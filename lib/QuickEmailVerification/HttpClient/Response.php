<?php

namespace QuickEmailVerification\HttpClient;

/*
 * Response object contains the response returned by the client
 */
class Response
{
    /**
     * @var array
     */
    public $body;

    /**
     * @var int
     */
    public $code;

    /**
     * @var array|null
     */
    public $headers;

    /**
     * @param array|string|\GuzzleHttp\EntityBodyInterface $body
     * @param int $code
     * @param array|null
     */
    public function __construct($body, $code, $headers = null)
    {
        $this->body = $body;
        $this->code = $code;
        $this->headers = $headers;
    }
}
