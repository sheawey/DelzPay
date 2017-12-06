<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Response as BaseResponse;

/**
 * 支付宝请求Response抽象类
 *
 * @package Delz\Pay\Alipay\Message
 */
abstract class Response extends BaseResponse
{
    /**
     * 业务是否成功
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->data['msg'] == 'Success' && $this->data['code'] == '10000';
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorCode()
    {
        if ($this->data['code'] != '10000') {
            return $this->data['code'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage()
    {
        if ($this->data['msg'] != 'Success') {
            return $this->data['msg'];
        }

        return null;
    }
}