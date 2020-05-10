<?php

namespace Ajuchacko\Payu\Concerns;

trait HasOptions {
    /**
     * Get MerchantId provided by payment gateway.
     *
     * @var string
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * Get Secret provided by payment gateway.
     *
     * @var string
     */
    public function getSecretKey()
    {
        return $this->secret_key;
    }

    /**
     * Get the mode.
     *
     * @var bool
     */
    public function getTestMode()
    {
        return $this->test_mode;
    }
}
