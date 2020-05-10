<?php

namespace Ajuchacko\Payu;

use Ajuchacko\Payu\Concerns\HasOptions;
use Ajuchacko\Payu\Exceptions\InvalidParameterException;

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

    public static function create(array $params): self
    {
        $checksum = new self($params['merchant_key'], $params['secret_key'], $params['test_mode']);

        $checksum->validateRequiredParams($params);

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

    private function validateRequiredParams(array $params)
    {
        $requiredParams = ['txnid', 'amount', 'firstname', 'email', 'phone', 'productinfo', 'surl', 'furl'];

        foreach ($requiredParams as $requiredParam) {
            if (!isset($params[$requiredParam])) {
                throw InvalidParameterException::create(sprintf('"%s" is a required param.', $requiredParam));
            }
        }

        if ($this->getTestMode()) {
            $this->additionalValidations($params);
        }
    }

    private function additionalValidations(array $params)
    {
        if (!is_string($params['txnid']) || strlen($params['txnid']) > 30) {
            throw InvalidParameterException::create('txnid must be string and may not be greater than 30 characters');
        }

        if (!is_float($params['amount'])) {
            throw  InvalidParameterException::create('Amount must be float.' . gettype($params['amount']) . 'Given');

        }

        if (!ctype_digit($params['phone'])) {
            throw  InvalidParameterException::create('Phone must only contain numeric values.');
        }
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

    public function getStringFromHashGenerated(): string
    {
        return $this->parameter_string;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
