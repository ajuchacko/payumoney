<?php

namespace Ajuchacko\Payu;

use Ajuchacko\Payu\Concerns\HasOptions;
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

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $resolver = (new OptionsResolver())
            ->setRequired(['merchant_id', 'secret_key', 'test_mode'])
            ->setAllowedTypes('merchant_id', 'string')
            ->setAllowedTypes('secret_key', 'string')
            ->setAllowedTypes('test_mode', 'bool');

        $options = $resolver->resolve($options);

        $this->merchant_id = $options['merchant_id'];
        $this->secret_key = $options['secret_key'];
        $this->test_mode = $options['test_mode'];
    }

    /**
     * Get payment url.
     *
     * @var string
     */
    public function getServiceUrl()
    {
        return $this->test_mode ? self::TEST_URL : self::PRODUCTION_URL;
    }

}
