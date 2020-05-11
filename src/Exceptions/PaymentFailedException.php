<?php

namespace Ajuchacko\Payu\Exceptions;

use Exception;

class PaymentFailedException extends Exception
{

    public function __construct()
    {
        parent::__construct(
            "Payment Failed."
        );
    }

}
