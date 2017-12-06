<?php

namespace Delz\Pay\Alipay;

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
        return $this->createRequest('Delz\Pay\Alipay\Message\CreatePayOrderRequest', $parameters);
    }


}