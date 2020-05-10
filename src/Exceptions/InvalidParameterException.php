<?php

namespace Ajuchacko\Payu\Exceptions;

use InvalidArgumentException;

class InvalidParameterException extends InvalidArgumentException
{

    public static function create(string $message)
    {
        return new static($message);
    }

}
