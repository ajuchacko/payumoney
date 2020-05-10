<?php

namespace Ajuchacko\Payu;

use Ajuchacko\Payu\Concerns\HasOptions;
use Ajuchacko\Payu\Exceptions\InvalidParameterException;
use Ajuchacko\Payu\ParameterValidator;
use Ajuchacko\Payu\PayuGateway;

class Checksum
{
    use HasOptions;

    private $hash;
    private $test_mode;
    private $secret_key;
    private $merchant_key;
    private $parameter_string;

    public function __construct(string $merchant_key, string  $secret_key, bool $test_mode)
    {
        $this->merchant_key = $merchant_key;
        $this->secret_key = $secret_key;
        $this->test_mode = $test_mode;
    }

    public static function make($merchant_key, $secret_key, $test_mode)
    {
        return new self($merchant_key, $secret_key, $test_mode);
    }

    public static function create(array $params): self
    {
        $checksum = self::make($params['merchant_key'], $params['secret_key'], $params['test_mode']);

        ParameterValidator::validate($params, $checksum->getTestMode());

        $checksum->parameter_string = $checksum->generateParameterString($params);

        $checksum->hash = strtolower(hash('sha512', $checksum->parameter_string));

        return $checksum;
    }

    private function generateParameterString(array $params): string
    {
        $values = array_map(
            function ($field) use ($params) {
                return isset($params[$field]) ? $params[$field] : '';
            },
            $this->getChecksumParams()
        );

        $values = array_merge([$this->getMerchantKey()], $values, [$this->getSecretKey()]);
        return implode('|', $values);
    }

    private function getChecksumParams(): array
    {
        return array_merge(
            ['txnid', 'amount', 'productinfo', 'firstname', 'email'],
            array_map(function ($i) {
                return "udf{$i}";
            }, range(1, 10))
        );
    }

    public static function valid($params, PayuGateway $payu)
    {
        $checksum = self::make($payu->getMerchantKey(), $payu->getSecretKey(), $payu->getTestMode());

        $response_hash = isset($params['hash']) ? (string) $params['hash'] : null;

        $checksumParams = array_reverse(array_merge(['key'], $checksum->getChecksumParams(), ['status', 'salt']));

        $params = array_merge($params, ['salt' => $checksum->getSecretKey()]);

        $values = array_map(
            function ($paramName) use ($params) {
                return array_key_exists($paramName, $params) ? $params[$paramName] : '';
            },
            $checksumParams
        );

        return hash('sha512', implode('|', $values)) === $response_hash;
    }

    public function getStringFromHashGenerated(): string
    {
        return $this->parameter_string;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
