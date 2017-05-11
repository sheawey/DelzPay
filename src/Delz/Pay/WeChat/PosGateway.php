<?php

namespace Delz\Pay\WeChat;

/**
 * 刷卡支付
 * @package Delz\Pay\WeChat
 */
class PosGateway extends Gateway
{
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Delz\Pay\WeChat\Message\MicroOrderRequest', $parameters);
    }
}