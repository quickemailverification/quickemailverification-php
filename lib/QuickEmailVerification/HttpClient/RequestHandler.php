<?php

namespace QuickEmailVerification\HttpClient;

use Guzzle\Http\Message\RequestInterface;

/**
 * RequestHandler takes care of encoding the request body into format given by options
 */
class RequestHandler {

    public static function setBody(RequestInterface $request, $body, $options)
    {
        $type = isset($options['request_type']) ? $options['request_type'] : 'json';
        $header = null;

        // Encoding request body into JSON format
        if ($type == 'json') {
            $body = ((count($body) === 0) ? '{}' : json_encode($body, empty($body) ? JSON_FORCE_OBJECT : 0));
            return $request->setBody($body, 'application/json');
        }

        if ($type == 'raw') {
            // Raw body
            return $request->setBody($body, $header);
        }
    }

}
