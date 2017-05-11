<?php

namespace Delz\Pay\WeChat;

/**
 * APP支付
 *
 * @package Delz\Pay\WeChat
 * @see https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=8_1
 */
class AppGateway extends Gateway
{
    public function getTradeType()
    {
        return 'APP';
    }
}