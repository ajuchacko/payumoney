<?php

namespace Tests;

use Ajuchacko\Payu\PayuGateway;
use PHPUnit\Framework\TestCase;

class PayuGatewayTest extends TestCase
{
	function testCanInstantiatePaymentGateway()
	{
		$params = [
			"merchant_id" => "testMerchantId",
			"secret_key"  => "testSecret",
			"test_mode"   => true,
		];

		$payu = new PayuGateway($params);

		$this->assertInstanceOf(PayuGateway::class, $payu);
	}

    function CanCreateHashUsingPaymentParams()
    {
        $params = [
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
        ];

        $payu = new PayuGateway($params);

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


    }
}
