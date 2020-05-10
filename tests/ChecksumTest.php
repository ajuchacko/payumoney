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
            'merchant_id' => 'testMerchantId',
            'secret_key'  => 'testSecret',
            'merchant_key'=> 'testMerchantKey',
            'test_mode'   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);

        $this->assertEquals('testMerchantKey|zcvnlfjdkf324|12|Iphone|Jon Doe|jon@mail.com|||||||||||testSecret',
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
            'merchant_id' => 'testMerchantId',
            'secret_key'  => 'testSecret',
            'merchant_key'=> 'testMerchantKey',
            'test_mode'   => true,
            'txnid'       => 'zcvnlfjdkf324',
            'amount'      => 12.00,
            'productinfo' => 'Iphone',
            'firstname'   => 'Jon Doe',
            'email'       => 'jon@mail.com',
            'phone'       => '9895309090',
            'surl'        => 'https://example.com/success',
            'furl'        => 'https://example.com/failure',
        ]);

        $this->assertEquals('testMerchantKey|zcvnlfjdkf324|12|Iphone|Jon Doe|jon@mail.com|udf one|udf two|udf three|udf four|udf five||||||testSecret',
            $hash->getStringFromHashGenerated());
    }
}
