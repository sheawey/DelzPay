<?php

namespace Delz\Pay\Alipay\Message;

/**
 * 声波支付
 *
 * @package Delz\Pay\Alipay\Message
 */
class CreateWaveCodeOrderRequest extends CreatePayOrderRequest
{
    /**
     * {@inheritdoc}
     */
    public function getScene()
    {
        return 'wave_code';
    }
}