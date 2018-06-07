<?php

namespace QuickEmailVerification\Api;

use QuickEmailVerification\HttpClient\Response;

interface QuickEmailVerificationInterface
{
    /**
     * @param $email
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function verify($email, array $options = []);

    /**
     * @param $email
     * @param array $options
     * @return Response
     * @throws \ErrorException|\RuntimeException
     */
    public function sandbox($email, array $options = []);
}
