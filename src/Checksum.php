<?php

namespace Ajuchacko\Payu;

use Ajuchacko\Payu\Concerns\HasOptions;

class Checksum
{
    use HasOptions;

    private $hash;
    private $test_mode;
    private $secret_key;
    private $merchant_id;
    private $parameter_string;

    public function __construct(string $merchant_id, string  $secret_key, bool $test_mode)
    {
        $this->merchant_id = $merchant_id;
        $this->secret_key = $secret_key;
        $this->test_mode = $test_mode;
    }

    public static function create(array $params): self
    {
        $checksum = new self($params['merchant_id'], $params['secret_key'], $params['test_mode']);

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

        $values = array_merge([$this->getMerchantId()], $values, [$this->getSecretKey()]);
        return implode('|', $values);
    }

    private function validateRequiredParams(array $params)
    {
        $requiredParams = ['txnid', 'amount', 'firstname', 'email', 'phone', 'productinfo', 'surl', 'furl'];

        foreach ($requiredParams as $requiredParam) {
            if (!isset($params[$requiredParam])) {
                throw new \InvalidArgumentException(sprintf('"%s" is a required param.', $requiredParam));
            }
        }

        if ($this->getTestMode()) {
            $this->additionalValidations($params);
        }
    }

    private function additionalValidations(array $params)
    {
        if (!is_string($params['txnid']) || strlen($params['txnid']) > 30) {
            $error = 'txnid must be string and may not be greater than 30 characters';
            throw new \InvalidArgumentException(sprintf('"%s" is a required param.', 'txnid'));
        }

        if (!is_float($params['amount'])) {
            $error = 'Amount must be float.' . gettype($params['amount']) . 'Given';
            throw new \InvalidArgumentException(sprintf('"%s" is a required param.', $error));
        }

        if (!ctype_digit($params['phone'])) {
            $error = 'Phone must only contain numeric values.';
            throw new \InvalidArgumentException(sprintf('"%s" is a required param.', $error));
        }
    }

    private function getChecksumParams()
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
}
