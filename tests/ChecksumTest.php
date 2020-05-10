<?php

namespace Tests;

use Ajuchacko\Payu\Checksum;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ChecksumTest extends TestCase
{

    function testCanGetValidParameterStringToGenerateHash()
    {
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
            'furl'        => 'https://example.com/failure',
        ]);

        $this->assertEquals('testMerchantId|zcvnlfjdkf324|12|Iphone|Jon Doe|jon@mail.com|||||||||||testSecret',
            $hash->getStringFromHashGenerated());
    }

    function testCanAddFiveUserdefinedParametersToGenerateHash()
    {
        $hash = Checksum::create([
            'udf1'        => 'udf one',
            'udf2'        => 'udf two',
            'udf3'        => 'udf three',
            'udf4'        => 'udf four',
            'udf5'        => 'udf five',
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
            'furl'        => 'https://example.com/failure',
        ]);

        $this->assertEquals('testMerchantId|zcvnlfjdkf324|12|Iphone|Jon Doe|jon@mail.com|udf one|udf two|udf three|udf four|udf five||||||testSecret',
            $hash->getStringFromHashGenerated());
    }

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

    // function testValidTransactionIsRequiredToCreateHash()
    // {
    //     $this->expectException(InvalidArgumentException::class);

    //     $hash = Checksum::create([
    //         'txnid'       => 'thisIsUserProvidedTooLongTransactionId',
    //         'amount'      => 12.00,
    //         'productinfo' => 'Iphone',
    //         'firstname'   => 'Jon Doe',
    //         'email'       => 'jon@mail.com',
    //         'phone'       => '9895309090',
    //         'surl'        => 'https://example.com/success',
    //         'furl'        => 'https://example.com/failure',
    //     ]);
    // }

    function testValidAmountIsRequiredToCreateHash()
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
