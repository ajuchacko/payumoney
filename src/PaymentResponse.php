<?php

namespace Ajuchacko\Payu;

use Exception;
use Ajuchacko\Payu\Enums\PaymentStatusType;

class PaymentResponse
{
    private $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    public static function make($response)
    {
        return new self($response);
    }

    public function getParams()
    {
        return $this->response;
    }

    public function getTransactionId()
    {
        return isset($this->response['mihpayid']) ? (string) $this->response['mihpayid'] : null;
    }

    public function getTransactionStatus()
    {
        return isset($this->response['status']) ? (string) $this->response['status'] : null;
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

    public function __get($name)
    {
        if (!isset($this->response[$name])) {
             throw new Exception ("Response Parameter {$name} is not defined");
        }

        return $this->response[$name];
    }

    public function toArray()
    {
        return $this->response;
    }
}
