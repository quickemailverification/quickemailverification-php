<?php

namespace QuickEmailVerification\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Main HttpClient which is used by Api classes
 * @package QuickEmailVerification\HttpClient
 */
class HttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private static $options = [
        'base_uri'=>'http://api.quickemailverification.com',
        'api_version' => 'v1',
        'headers' => [
            'user-agent' => 'quickemailverification-php/v1.0.2 (https://github.com/quickemailverification/quickemailverification-php)'
        ]
    ];

    /**
     * @param string $auth
     * @param array $options
     */
    public function __construct($auth = '', array $options = [])
    {
        $options = array_merge(self::$options, $options);

        $options['headers']['Authorization'] = sprintf('token %s', $auth);
        $this->client = new Client($options);
    }

    /**
     * @param $path
     * @param array $body
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function get($path, array $params = [], array $options = [])
    {
        return $this->request($path, [], 'GET', array_merge($options, ['query' => $params]));
    }

    /**
     * @param $path
     * @param array $body
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function post($path, $body, array $options = [])
    {
        return $this->request($path, $body, 'POST', $options);
    }

    /**
     * @param $path
     * @param array $body
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function patch($path, $body, array $options = [])
    {
        return $this->request($path, $body, 'PATCH', $options);
    }

    /**
     * @param $path
     * @param array $body
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function delete($path, $body, array $options = [])
    {
        return $this->request($path, $body, 'DELETE', $options);
    }

    /**
     * @param $path
     * @param array $body
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function put($path, $body, array $options = [])
    {
        return $this->request($path, $body, 'PUT', $options);
    }

    /**
     * @param $path
     * @param array $body
     * @param string $httpMethod
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    private function request($path, array $body = [], $httpMethod = 'GET', array $options = [])
    {
        if (isset($options['body'])) {
            $body = array_merge($options['body'], $body);
        }

        $headers = [];
        if (isset($options['headers'])) {
            $headers = $options['headers'];
            unset($options['headers']);
        }

        $options['body'] = json_encode($body);
        $options['headers'] = array_merge($headers, self::$options['headers']);
        $options = array_merge($options, self::$options);

        try {
            $response = $this->client->request($httpMethod, $path, $options);
        } catch (BadResponseException $e) {
            throw new \ErrorException($e->getMessage(), $e->getResponse()->getStatusCode());
        } catch (\LogicException $e) {
            throw new \ErrorException($e->getMessage(), $e->getCode());
        } catch (\RuntimeException $e) {
            throw new \ErrorException($e->getMessage(), $e->getCode());
        }

        return new Response(json_decode($response->getBody()->getContents(), true), $response->getStatusCode(), $response->getHeaders());
    }
}
