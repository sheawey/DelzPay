<?php

namespace Delz\Pay\Alipay;

use Delz\Pay\Alipay\Message\CreatePageOrderRequest;

/**
 * 电脑网站支付
 *
 * @package Delz\Pay\Alipay
 */
class PageGateway extends Gateway
{
    /**
     * {@inheritdoc}
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(CreatePageOrderRequest::class, $parameters);
    }
}