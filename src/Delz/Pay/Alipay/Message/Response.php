<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Response as BaseResponse;
use Delz\Pay\Alipay\Helper;
use Delz\Pay\Common\Contract\IRequest;

/**
 * 支付宝请求Response抽象类
 *
 * @package Delz\Pay\Alipay\Message
 */
abstract class Response extends BaseResponse
{
    /**
     * 签名是否正确
     *
     * @var bool
     */
    protected $isSignOk = false;

    /**
     * 业务是否成功
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->isSignOk && $this->data['msg'] == 'Success' && $this->data['code'] == '10000';
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

    /**
     * 验证签名
     *
     * @param string $sign
     */
    protected function checkSign($sign)
    {
        $this->isSignOk = Helper::verifySign($this->data, $sign, $this->request->getPublicKey(), $this->request->getSignType());
    }
}