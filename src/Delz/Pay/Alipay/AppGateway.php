<?php

namespace Delz\Pay\Alipay;

use Delz\Pay\Alipay\Message\CreateAppOrderRequest;

/**
 * App支付
 *
 * @package Delz\Pay\Alipay
 */
class AppGateway extends Gateway
{
    /**
     * {@inheritdoc}
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(CreateAppOrderRequest::class, $parameters);
    }
}