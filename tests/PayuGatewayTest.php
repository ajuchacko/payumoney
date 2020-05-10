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
            'txnid'       => $userDetails['id'],
            'amount'      => $userDetails['total_amount'],
            'productinfo' => $userDetails['name'],
            'firstname'   => $userDetails['name'],
            'email'       => $userDetails['email'],
            'phone'       => $mob,
            'udf1'        => $userDetails['email'],
            'udf2'        => $mob,
            'surl'        => url('success'),
            'furl'        => url('failure'),
        ];


    }
}
