<?php

namespace Ajuchacko\Payu;

use Ajuchacko\Payu\Checksum;
use Ajuchacko\Payu\Concerns\HasOptions;
use Ajuchacko\Payu\Enums\PaymentStatusType;
use Ajuchacko\Payu\Exceptions\InvalidChecksumException;
use Ajuchacko\Payu\HttpResponse;
use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PayuGateway
{
    use HasOptions;

	const TEST_URL = 'https://sandboxsecure.payu.in/_payment';

    const PRODUCTION_URL = 'https://secure.payu.in/_payment';

    /**
     * Payment gateway provided id.
     *
     * @var string
     */
    private $merchant_id;

    /**
     * Payment gateway provided secret key.
     *
     * @var string
     */
    private $secret_key;

    /**
     * Denotes is in test mode.
     *
     * @var bool
     */
    private $test_mode;

    private $checksum;

    private $params;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $resolver = (new OptionsResolver())
            ->setRequired(['merchant_id', 'merchant_key', 'secret_key', 'test_mode'])
            ->setAllowedTypes('merchant_id', 'string')
            ->setAllowedTypes('merchant_key', 'string')
            ->setAllowedTypes('secret_key', 'string')
            ->setAllowedTypes('test_mode', 'bool');

        $options = $resolver->resolve($options);

        $this->merchant_id = $options['merchant_id'];
        $this->merchant_key = $options['merchant_key'];
        $this->secret_key = $options['secret_key'];
        $this->test_mode = $options['test_mode'];
    }

    /**
     * Get payment url.
     *
     * @var string
     */
    public function getPaymentUrl()
    {
        return $this->test_mode ? self::TEST_URL : self::PRODUCTION_URL;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function newChecksum(array $params): string
    {
        $this->setParams($params);

        $all_params = array_merge($this->getParams(), [
            'merchant_key' => $this->getMerchantKey(),
            'secret_key'  => $this->getSecretKey(),
            'test_mode'   => $this->getTestMode(),
        ]);

        $this->checksum = Checksum::create($all_params);

        return $this->checksum->getHash();
    }

    public function pay(array $params)
    {
        $this->setParams($params);

        $params = array_merge($params, ['hash' => $this->newChecksum($this->getParams()), 'key' => $this->getMerchantKey()]);

        return HttpResponse::make($params, $this->getPaymentUrl());
    }

    public function getPaymentResponse($response)
    {
        if (! Checksum::valid($response, $this)) {
            throw new InvalidChecksumException;
        }

        return PaymentResponse::make($response);
    }

    public function paymentSuccess($response)
    {
        $response = $this->getPaymentResponse($response);
        if ($response->getStatus() === PaymentStatusType::STATUS_COMPLETED) {
            return $response;
        }
    }

    public function toArray(): array
    {
        return [
            'merchant_id' => $this->getMerchantId(),
            'merchant_key'=> $this->getMerchantKey(),
            'txnid'       => $this->txnid,
            'amount'      => $this->amount,
            'productinfo' => $this->productinfo,
            'firstname'   => $this->firstname,
            'email'       => $this->email,
            'phone'       => $this->phone,
            'surl'        => $this->surl,
            'furl'        => $this->furl,
            'hash'        => $this->checksum->getHash(),
            'sandbox'     => $this->getTestMode(),
        ];
    }

    public function __get($name)
    {
        if (!isset($this->params[$name])) {
             throw new Exception ("Property {$name} is not defined");
        }

        return $this->params[$name];
    }
}
