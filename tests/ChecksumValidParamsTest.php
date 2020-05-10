<?php

namespace Tests;

use Ajuchacko\Payu\Checksum;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ChecksumValidParamsTest extends TestCase
{
    function testTransactionIdIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            // 'txnid'       => $userDetails['id'], // string 30 characters
            'amount'      => 12.00, // float
            'productinfo' => 'Iphone', // string|json
            'firstname'   => 'Jon Doe', // string(only alpha)
            'email'       => 'jon@mail.com', // string
            'phone'       => '9895309090', // string(only numeric)
            // 'udf1'        => $userDetails['email'],
            // 'udf2'        => $mob,
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    function testValidTransactionIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'thisIsUserProvidedTooLongTransactionId',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    function testAmountIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    function testValidAmountIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    function testFirstnameIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            // 'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    // function testFirstnameContainsOnlyAlphaCharacters()
    // {
    //     $this->expectException(InvalidArgumentException::class);

    //     $hash = Checksum::create([
    //         "merchant_id" => "testMerchantId",
    //         "secret_key"  => "testSecret",
    //         "test_mode"   => true,
    //         'txnid'       => 'zcvnlfjdkf324',
    //         'amount'      => 12.00,
    //         'productinfo' => 'Iphone',
    //         'firstname'   => 'Mr. Jon Doe',
    //         'email'       => 'jon@mail.com',
    //         'phone'       => '9895309090',
    //         'surl'        => 'https://example.com/success',
    //         'furl'        => 'https://example.com/failure',
    //     ]);
    // }

    function testEmailIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            // 'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    function testPhoneIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            // 'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    function testPhoneContainsOnlyNumericRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '+919895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    function testProductIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            // 'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    function testSuccessUrlIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            // 'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);
    }

    function testFailureUrlIsRequiredToCreateHash()
    {
        $this->expectException(InvalidArgumentException::class);

        $hash = Checksum::create([
            "merchant_id" => "testMerchantId",
            "secret_key"  => "testSecret",
            "test_mode"   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            // 'furl'        => 'https://example.com/failure',
        ]);
    }
}
