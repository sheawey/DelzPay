<?php

namespace Delz\Pay\WeChat;

/**
 * 公众号支付
 *
 * @package Delz\Pay\WeChat
 * @see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=7_1
 */
class JsGateway extends Gateway
{
    public function getTradeType()
    {
        return 'JSAPI';
    }
}