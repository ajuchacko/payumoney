<?php

namespace Tests;

use Ajuchacko\Payu\PayuGateway;
use PHPUnit\Framework\TestCase;

class PayuGatewayTest extends TestCase
{

    function setUp(): void
    {
        $params = [
            "merchant_id" => "testMerchantId",
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
        $params = [
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

        $hash_one = $this->payu->newChecksum($params);
        $hash_two = $this->payu->newChecksum($params);

        $this->assertTrue(hash_equals($hash_one, $hash_two));
    }
}
