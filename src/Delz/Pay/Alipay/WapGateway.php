<?php

namespace Delz\Pay\Alipay;

use Delz\Pay\Alipay\Message\CreateWapOrderRequest;

/**
 * 手机网站支付
 *
 * @package Delz\Pay\Alipay
 */
class WapGateway extends Gateway
{
    /**
     * {@inheritdoc}
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(CreateWapOrderRequest::class, $parameters);
    }
}