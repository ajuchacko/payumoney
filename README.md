# PayUMoney Php


Library for integrating payumoney easily to your laravel/php apps.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install package.

```bash
composer install ajuchacko/payumoney
```

## Usage

```php
<?php

use Ajuchacko\Payu\PayuGateway;


$params = [
    'txnid'       => '134',
    'amount'      => 12.00,
    'productinfo' => 'Iphone',
    'firstname'   => 'Jon Doe',
    'email'       => 'jon@mail.com',
    'phone'       => '9895309090',
    'surl'        => 'https://example.com/success',
    'furl'        => 'https://example.com/failure',
    'udf1'        => 'Secret value',
];

$payu = new PayuGateway([
    "secret_key"  => "testSecret",
    "merchant_key"=> "testMerchantKey",
    "merchant_id" => "7974556",
    "test_mode"   => false,
]);

$payu->pay($params); // Redirects to PayUMoney

// OR

$hash = $payu->newChecksum($params);
$payu->toArray(); // Returns array or parameters which can be submitted via web/mobile app.

```

## Payment Response

```php
use Ajuchacko\Payu\PayuGateway;

$payu = new PayuGateway([
    "secret_key"  => "testSecret",
    "merchant_key"  => "testMerchantKey",
    "merchant_id" => "7974556",
    "test_mode"   => true,
]);


try {
    $response = $payu->getPaymentResponse($request->all());
    if ($response->getStatus() === PaymentStatusType::STATUS_COMPLETED) {
        # code...
    }

    // OR

    if ($response = $payu->paymentSuccess($request->all())) {
        # code...
    }
} catch (InvalidChecksumException $e) {
  // Checksum is tampered
}
```
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
