<?php

namespace Delz\Pay\WeChat;

/**
 * 扫码支付
 *
 * @package Delz\Pay\WeChat
 */
class NativeGateway extends Gateway
{
    public function getTradeType()
    {
        return 'NATIVE';
    }
}