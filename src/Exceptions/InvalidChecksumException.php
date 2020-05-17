<?php

namespace Ajuchacko\Payu\Exceptions;

use Exception;

class InvalidChecksumException extends Exception
{
    /**
     * Create a new Invalid Checksum exception instance.
     *
     * @return string
     */
    public function __construct()
    {
        parent::__construct(
            "Provided Checksum is invalid."
        );
    }

}
