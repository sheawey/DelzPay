<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Pay\Common\Response as BaseResponse;

/**
 * 微信支付返回结果抽象类
 *
 * @package Delz\Pay\WeChat\Message
 */
abstract class Response extends BaseResponse
{
    /**
     * 业务是否成功
     *
     * 微信支付一般请求会返回两个结果
     *
     * return_code 通信标识,表示请求是否成功,非交易标识, SUCCESS or FAIL
     * result_code 业务结果,交易标识,SUCCESS or FAIL
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return isset($this->data['return_code']) && $this->data['return_code'] == 'SUCCESS' && isset($this->data['result_code']) && $this->data['result_code'] == 'SUCCESS';
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorCode()
    {
        if (isset($this->data['err_code'])) {
            return $this->data['err_code'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage()
    {
        if (isset($this->data['err_code_des'])) {
            return $this->data['err_code_des'];
        }

        return null;
    }
}