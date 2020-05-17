<?php

namespace Ajuchacko\Payu;

use Ajuchacko\Payu\Concerns\HasConfig;
use Ajuchacko\Payu\Exceptions\InvalidParameterException;
use Ajuchacko\Payu\ParameterValidator;
use Ajuchacko\Payu\PayuGateway;

class Checksum
{
    use HasConfig;

    /**
     * Generated Hash String
     *
     * @var bool
     */
    private $hash;

    /**
     * Denotes is in test mode
     *
     * @var bool
     */
    private $test_mode;

    /**
     * Secret provided by payment gateway
     *
     * @var bool
     */
    private $secret_key;

    /**
     * Merchant key provided by payment gateway
     *
     * @var bool
     */
    private $merchant_key;

    /**
     * Generated string to create hash
     *
     * @var bool
     */
    private $parameter_string;

    /**
     * Create the instance of checksum
     * 
     * @param  string $merchant_key
     * @param  string $secret_key
     * @param  bool   $test_mode
     * @return void
     */
    public function __construct(string $merchant_key, string  $secret_key, bool $test_mode)
    {
        $this->merchant_key = $merchant_key;
        $this->secret_key = $secret_key;
        $this->test_mode = $test_mode;
    }

    /**
     * Create the instance of checksum
     * 
     * @param  string $merchant_key
     * @param  string $secret_key
     * @param  bool   $test_mode
     * @return $this
     */
    public static function make($merchant_key, $secret_key, $test_mode)
    {
        return new self($merchant_key, $secret_key, $test_mode);
    }

    /**
     * Generates hash from the checksum instance
     * 
     * @param  array $params
     * @return $this
     */
    public static function create(array $params): self
    {
        $checksum = self::make($params['merchant_key'], $params['secret_key'], $params['test_mode']);

        ParameterValidator::validate($params, $checksum->getTestMode());

        $checksum->parameter_string = $checksum->generateParameterString($params);

        $checksum->hash = strtolower(hash('sha512', $checksum->parameter_string));

        return $checksum;
    }

    /**
     * Generates string to create hash
     * 
     * @param  array  $params
     * @return string 
     */
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

    /**
     * Get all the required field names including udf to generate hash
     * 
     * @return array
     */
    private function getChecksumParams(): array
    {
        return array_merge(
            ['txnid', 'amount', 'productinfo', 'firstname', 'email'],
            array_map(function ($i) {
                return "udf{$i}";
            }, range(1, 10))
        );
    }

    /**
     * Checks given checksum in params array is valid
     * 
     * @param  array                      $params
     * @param  Ajuchacko\Payu\PayuGateway $payu
     * @return bool
     */
    public static function valid(array $params, PayuGateway $payu)
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

    /**
     * Get the created string to generate hash 
     * 
     * @return string
     */
    public function getStringFromHashGenerated(): string
    {
        return $this->parameter_string;
    }

    /**
     * Get the Hash generated
     * 
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}
