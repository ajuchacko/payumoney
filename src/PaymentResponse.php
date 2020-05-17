<?php

namespace Ajuchacko\Payu;

use Exception;
use Ajuchacko\Payu\Enums\PaymentStatusType;

class PaymentResponse
{
    /**
     * Response params provided
     *
     * @var string
     */
    private $response;

    /**
     * Create an instance of Payment Response
     * 
     * @param  array $response
     * @return void
     */
    public function __construct(array $response)
    {
        $this->response = $response;
    }

    /**
     * Create an instance of Payment Response
     * 
     * @param  array $response
     * @return Ajuchacko\Payu\PaymentResponse
     */
    public static function make(array $response)
    {
        return new self($response);
    }

    /**
     * Get the response params provided
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->response;
    }

    /**
     * Get the transaction id of the response
     * 
     * @return string|null
     */
    public function getTransactionId()
    {
        return isset($this->response['mihpayid']) ? (string) $this->response['mihpayid'] : null;
    }

    /**
     * Get the transaction status of the response
     * 
     * @return string|null
     */
    public function getTransactionStatus()
    {
        return isset($this->response['status']) ? (string) $this->response['status'] : null;
    }

    /**
     * Get the transaction status
     * 
     * @return string
     */
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

    /**
     * Get response params as properties of respones instance
     * 
     * @param  string $name
     * @return string
     * 
     * @throws \Exception
     */
    public function __get($name)
    {
        if (!isset($this->response[$name])) {
             throw new Exception ("Response Parameter {$name} is not defined");
        }

        return $this->response[$name];
    }

    /**
     * Converts instance to an array
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}
