<?php

namespace Ajuchacko\Payu;

use Ajuchacko\Payu\Enums\PaymentStatusType;

class PaymentResponse
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public static function make($response)
    {
        return new self($response);
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getTransactionId()
    {
        return isset($this->params['mihpayid']) ? (string) $this->params['mihpayid'] : null;
    }

    public function getTransactionStatus()
    {
        return isset($this->params['status']) ? (string) $this->params['status'] : null;
    }

    public function getStatus()
    {
        switch (strtolower($this->getTransactionStatus())) {
            case 'success':
                return PaymentStatusType::STATUS_COMPLETED;
                break;
            case 'pending':
                return PaymentStatusType::STATUS_PENDING;
                break;
            case 'failure':
            default:
                return PaymentStatusType::STATUS_FAILED;
        }
    }
}
