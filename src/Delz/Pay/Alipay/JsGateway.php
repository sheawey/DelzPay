<?php

namespace Delz\Pay\Alipay;

use Delz\Pay\Alipay\Message\CreateOrderRequest;

/**
 * 生活号支付
 * @package Delz\Pay\Alipay
 */
class JsGateway extends Gateway
{
    /**
     * {@inheritdoc}
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(CreateOrderRequest::class, $parameters);
    }
}