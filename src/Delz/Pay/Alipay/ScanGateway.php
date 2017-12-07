<?php

namespace Delz\Pay\Alipay;

use Delz\Pay\Alipay\Message\CreatePreOrderRequest;

/**
 * 扫码支付
 *
 * @package Delz\Pay\Alipay
 */
class ScanGateway extends Gateway
{
    /**
     * {@inheritdoc}
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(CreatePreOrderRequest::class, $parameters);
    }
}