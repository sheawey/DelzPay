<?php

namespace Delz\Pay\Alipay;

use Delz\Pay\Alipay\Message\CreatePayOrderRequest;

/**
 * 条码支付
 *
 * @package Delz\Pay\Alipay
 */
class BarCodeGateway extends Gateway
{
    /**
     * {@inheritdoc}
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(CreatePayOrderRequest::class, $parameters);
    }


}