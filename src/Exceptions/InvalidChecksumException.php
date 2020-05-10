<?php

namespace Ajuchacko\Payu\Exceptions;

use Exception;

class InvalidChecksumException extends Exception
{

    public function __construct()
    {
        parent::__construct(
            "Provided Checksum is invalid."
        );
    }

}
