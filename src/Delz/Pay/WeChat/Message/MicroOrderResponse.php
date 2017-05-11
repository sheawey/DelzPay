<?php

namespace Delz\Pay\WeChat\Message;

/**
 * 刷卡支付返回结果
 *
 * 先用isSuccessful()判断是否支付成功，如果不成功，判断是否isPaying(),如果是调用查询订单每隔几秒查询判断
 *
 * @package Mkd\Pay\WeChat\Message
 */
class MicroOrderResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return $this->isPaid();
    }

    public function isPaying()
    {
        return isset($this->data['err_code']) &&
            in_array($this->data['err_code'], ['SYSTEMERROR', 'BANKERROR', 'USERPAYING']);
    }

    public function isPaid()
    {
        return isset($this->data['return_code']) &&
                $this->data['return_code'] == 'SUCCESS' &&
                isset($this->data['result_code']) &&
                $this->data['result_code'] == 'SUCCESS'
        ;
    }
}