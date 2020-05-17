<?php

namespace Ajuchacko\Payu\Exceptions;

use Exception;

class PaymentFailedException extends Exception
{
    /**
     * Create a new Payment Failed exception instance.
     *
     * @return string
     */
    public function __construct()
    {
        parent::__construct(
            "Payment Failed."
        );
    }

}
