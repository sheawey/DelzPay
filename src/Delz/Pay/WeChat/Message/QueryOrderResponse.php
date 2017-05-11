<?php

namespace Delz\Pay\WeChat\Message;

/**
 * 订单查询请求结果
 *
 * @package Delz\Pay\WeChat\Message
 */
class QueryOrderResponse extends Response
{
    public function isSuccessful()
    {
        return $this->isPaid();
    }

    public function isPaid()
    {
        return isset($this->data['trade_state']) && $this->data['trade_state'] == 'SUCCESS';
    }
}