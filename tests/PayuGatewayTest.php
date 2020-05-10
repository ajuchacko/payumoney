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
}