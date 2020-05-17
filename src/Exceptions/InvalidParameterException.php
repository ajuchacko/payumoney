<?php

namespace Ajuchacko\Payu\Exceptions;

use InvalidArgumentException;

class InvalidParameterException extends InvalidArgumentException
{
    /**
     * Create a new Invalid Parameter exception instance.
     *
     * @param  string $message
     * @return $this
     */
    public static function create(string $message)
    {
        return new self($message);
    }

}
