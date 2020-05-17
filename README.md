# PayuMoney Php


Library for integrating payumoney easily to your laravel/php apps using simple interface.

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
    "merchant_key"=> "testMerchantKey",
    "secret_key"  => "testSecret",
    "merchant_id" => "7974556",
    "test_mode"   => true,
]);

$payu->pay($params); // Redirects to PayUMoney

// OR

$hash = $payu->newChecksum($params);
$payu->toArray(); // Returns array or parameters which can be submitted via web/mobile app.

```
Get: [Test Credentials](https://stackoverflow.com/questions/47366514/what-are-the-current-payumoney-test-credentials/)

## Payment Response

```php
<?php

use Ajuchacko\Payu\PayuGateway;
use Ajuchacko\Payu\Exceptions\PaymentFailedException;
use Ajuchacko\Payu\Exceptions\InvalidChecksumException;

$payu = new PayuGateway([
    "merchant_key"=> "testMerchantKey",
    "secret_key"  => "testSecret",
    "merchant_id" => "7974556",
    "test_mode"   => true,
]);

try {
    
    $response = $payu->paymentSuccess($request->all())
    // $response->toArray();
    // $response->txnid // retrive response params as attributes

} catch (PaymentFailedException $e) {

    $response = $payu->getPaymentResponse($request->all());

} catch (InvalidChecksumException $e) {
    // Checksum is tampered
}

```
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.
