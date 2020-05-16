<?php

namespace Tests;

use Ajuchacko\Payu\PayuGateway;
use PHPUnit\Framework\TestCase;
use Ajuchacko\Payu\PaymentResponse;

class ResponseTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
        $response = json_decode(file_get_contents(__DIR__ . '/__fixtures__/response.json'), true);
        $this->payment_response = new PaymentResponse($response);
    }

    function testCanGetResponse()
    {
        $this->assertInstanceOf(PaymentResponse::class, $this->payment_response);
    }

    function testGetTransactionId()
    {
        $transaction_id = $this->payment_response->getTransactionId();
        $this->assertEquals('9083871705', $transaction_id);
    }

    function testGetStatusAsString()
    {
        $status_string = $this->payment_response->getStatus();
        $this->assertEquals('Completed', $status_string);
    }

    function testGetTransactionStatus()
    {
        $status = $this->payment_response->getTransactionStatus();
        $this->assertEquals('success', $status);
    }

    function testCanGetResponseProperties()
    {
        $this->assertEquals('12.00', $this->payment_response->amount);
        $this->assertEquals('Iphone', $this->payment_response->productinfo);
        $this->assertEquals('jon@mail.com', $this->payment_response->email);
        $this->assertEquals('zcvnlfjdkf324', $this->payment_response->txnid);
    }
    
    function testCanGetResponseAsArray()
    {
        $response = $this->payment_response->toArray();

        $this->assertEquals('zcvnlfjdkf324', $response['txnid']);
    }
}