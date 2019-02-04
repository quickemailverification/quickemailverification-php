<?php

namespace QuickEmailVerification\Test;

use QuickEmailVerification\Client;
use PHPUnit\Framework\TestCase;

class QevVerifyTest extends TestCase
{
    protected $quickemailverification = null;

    public function setup()
    {
        $api_key = getenv('apikey');

        if (!$api_key) {
            throw new \ErrorException('Invalid Api Key');
        }

        $client = new Client($api_key);
        $this->quickemailverification = $client->quickemailverification();
    }

    public function testVerifyValidEmail()
    {
        $response = $this->quickemailverification->sandbox('valid@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('valid', $body['result']);
        $this->assertEquals('accepted_email', $body['reason']);
        $this->assertEquals('true', $body['disposable']);
        $this->assertEquals('true', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('valid@example.com', $body['email']);
        $this->assertEquals('valid', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifySafeToSendEmail()
    {
        $response = $this->quickemailverification->sandbox('safe-to-send@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('valid', $body['result']);
        $this->assertEquals('accepted_email', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('safe-to-send@example.com', $body['email']);
        $this->assertEquals('safe-to-send', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('true', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyFreeEmail()
    {
        $response = $this->quickemailverification->sandbox('free@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('valid', $body['result']);
        $this->assertEquals('accepted_email', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('true', $body['free']);
        $this->assertEquals('free@example.com', $body['email']);
        $this->assertEquals('free', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('true', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyRejectedEmail()
    {
        $response = $this->quickemailverification->sandbox('rejected-email@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('invalid', $body['result']);
        $this->assertEquals('rejected_email', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('rejected-email@example.com', $body['email']);
        $this->assertEquals('rejected-email', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyInvalidDomain()
    {
        $response = $this->quickemailverification->sandbox('invalid-domain@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('invalid', $body['result']);
        $this->assertEquals('invalid_domain', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('invalid-domain@example.com', $body['email']);
        $this->assertEquals('invalid-domain', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyInvalidEmail()
    {
        $response = $this->quickemailverification->sandbox('invalid-email@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('invalid', $body['result']);
        $this->assertEquals('invalid_email', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('invalid-email@example.com', $body['email']);
        $this->assertEquals('invalid-email', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyExceededStorage()
    {
        $response = $this->quickemailverification->sandbox('exceeded-storage@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('invalid', $body['result']);
        $this->assertEquals('exceeded_storage', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('exceeded-storage@example.com', $body['email']);
        $this->assertEquals('exceeded-storage', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyNoMXRecord()
    {
        $response = $this->quickemailverification->sandbox('no-mx-record@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('invalid', $body['result']);
        $this->assertEquals('no_mx_record', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('no-mx-record@example.com', $body['email']);
        $this->assertEquals('no-mx-record', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyDidYouMean()
    {
        $response = $this->quickemailverification->sandbox('did-you-mean@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('invalid', $body['result']);
        $this->assertEquals('rejected_email', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('did-you-mean@example.com', $body['email']);
        $this->assertEquals('did-you-mean', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEquals('did-you-mean@example.com', $body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyTimeout()
    {
        $response = $this->quickemailverification->sandbox('timeout@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('unknown', $body['result']);
        $this->assertEquals('timeout', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('timeout@example.com', $body['email']);
        $this->assertEquals('timeout', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyUnexpectedError()
    {
        $response = $this->quickemailverification->sandbox('unexpected-error@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('unknown', $body['result']);
        $this->assertEquals('unexpected_error', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('unexpected-error@example.com', $body['email']);
        $this->assertEquals('unexpected-error', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyNoConnect()
    {
        $response = $this->quickemailverification->sandbox('no-connect@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('unknown', $body['result']);
        $this->assertEquals('no_connect', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('no-connect@example.com', $body['email']);
        $this->assertEquals('no-connect', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyUnavailableSMTP()
    {
        $response = $this->quickemailverification->sandbox('unavailable-smtp@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('unknown', $body['result']);
        $this->assertEquals('unavailable_smtp', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('unavailable-smtp@example.com', $body['email']);
        $this->assertEquals('unavailable-smtp', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyTemporarilyBlocked()
    {
        $response = $this->quickemailverification->sandbox('temporarily-blocked@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('unknown', $body['result']);
        $this->assertEquals('temporarily_blocked', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('temporarily-blocked@example.com', $body['email']);
        $this->assertEquals('temporarily-blocked', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyAcceptAll()
    {
        $response = $this->quickemailverification->sandbox('accept-all@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('valid', $body['result']);
        $this->assertEquals('accepted_email', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('true', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('accept-all@example.com', $body['email']);
        $this->assertEquals('accept-all', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyRole()
    {
        $response = $this->quickemailverification->sandbox('role@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('valid', $body['result']);
        $this->assertEquals('accepted_email', $body['reason']);
        $this->assertEquals('false', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('true', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('role@example.com', $body['email']);
        $this->assertEquals('role', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyDisposable()
    {
        $response = $this->quickemailverification->sandbox('disposable@example.com');
        $body = $response->body;

        $this->assertEquals(200, $response->code);
        $this->assertEquals('valid', $body['result']);
        $this->assertEquals('accepted_email', $body['reason']);
        $this->assertEquals('true', $body['disposable']);
        $this->assertEquals('false', $body['accept_all']);
        $this->assertEquals('false', $body['role']);
        $this->assertEquals('false', $body['free']);
        $this->assertEquals('disposable@example.com', $body['email']);
        $this->assertEquals('disposable', $body['user']);
        $this->assertEquals('example.com', $body['domain']);
        $this->assertEmpty($body['mx_record']);
        $this->assertEmpty($body['mx_domain']);
        $this->assertEquals('false', $body['safe_to_send']);
        $this->assertEmpty($body['did_you_mean']);
        $this->assertEquals('true', $body['success']);
    }

    public function testVerifyLowCredit()
    {
        $this->expectException(\ErrorException::class);
        $this->expectExceptionCode(402);
        $this->expectExceptionMessage('Low credit. Payment required');
        $this->quickemailverification->sandbox('low-credit@example.com');
    }

    public function tearDown()
    {
        unset($this->quickemailverification);
    }
}
