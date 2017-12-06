<?php

namespace Delz\Pay\Alipay;

/**
 * 声波支付
 *
 * @package Delz\Pay\Alipay
 */
class WaveCodeGateway extends BarCodeGateway
{
    /**
     * {@inheritdoc}
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('Delz\Pay\Alipay\Message\CreateWaveCodeOrderRequest', $parameters);
    }
}