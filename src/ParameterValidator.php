<?php

namespace Ajuchacko\Payu;

use Ajuchacko\Payu\Exceptions\InvalidParameterException;

class ParameterValidator
{
    public static function validate(array $params, bool $test_mode)
    {
        return self::validateRequiredParams($params, $test_mode);
    }

    private static function validateRequiredParams(array $params, bool $test_mode)
    {
        $requiredParams = ['txnid', 'amount', 'firstname', 'email', 'phone', 'productinfo', 'surl', 'furl'];

        foreach ($requiredParams as $requiredParam) {
            if (!isset($params[$requiredParam])) {
                throw InvalidParameterException::create(sprintf('"%s" is a required param.', $requiredParam));
            }
        }

        if ($test_mode) {
            self::additionalValidations($params);
        }
    }

    private static function additionalValidations(array $params)
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
}
