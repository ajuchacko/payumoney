<?php

namespace Tests;

use Ajuchacko\Payu\PayuGateway;
use PHPUnit\Framework\TestCase;

class PayuGatewayTest extends TestCase
{

    function setUp(): void
    {
        $params = [
            "merchant_id"  => "testMerchantId",
            "merchant_key" => "testMerchantKey",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
        ];

        $this->payu = new PayuGateway($params);
    }

	function testCanInstantiatePaymentGateway()
	{
		$this->assertInstanceOf(PayuGateway::class, $this->payu);
	}

    function testCanGetHashUsingPaymentParams()
    {
        $hash_one = $this->payu->newChecksum($this->validParams());
        $hash_two = $this->payu->newChecksum($this->validParams());

        $this->assertTrue(hash_equals($hash_one, $hash_two));
    }

    function testCanGetArrayOfAllParametersForPayment()
    {
        $hash = $this->payu->newChecksum($this->validParams());

        $this->assertEquals([
            'merchant_id' => 'testMerchantId',
            'merchant_key'=> 'testMerchantKey',
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
            'hash'        => $hash,
            'sandbox'     => true,
        ], $this->payu->toArray());
    }

    private function validParams(): array
    {
        return [
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
            'udf1'        => 'udf one',
            'udf2'        => 'udf two',
            'udf3'        => 'udf three',
            'udf4'        => 'udf four',
            'udf5'        => 'udf five',
        ];
    }
}
