<?php

namespace Delz\Pay\Alipay;

use Delz\Pay\Alipay\Message\CreateWaveCodeOrderRequest;

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
        return $this->createRequest(CreateWaveCodeOrderRequest::class, $parameters);
    }
}