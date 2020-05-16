<?php

namespace Ajuchacko\Payu\Concerns;

trait HasConfig {
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
     * Get MerchantKey provided by payment gateway.
     *
     * @var string
     */
    public function getMerchantKey()
    {
        return $this->merchant_key;
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
