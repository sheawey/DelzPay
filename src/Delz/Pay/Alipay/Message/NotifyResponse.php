<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Alipay\Gateway;
use Delz\Pay\Alipay\Helper;
use Delz\Pay\Common\Contract\IResponse;

/**
 * 异步通知结果类
 *
 * @package Delz\Pay\Alipay\Message
 */
class NotifyResponse implements IResponse
{
    /**
     * 支付网关
     *
     * @var Gateway
     */
    protected $gateway;

    /**
     * 异步通知参数
     *
     * @var array
     */
    protected $data;

    /**
     * 签名是否正确
     *
     * @var bool
     */
    protected $isSignOk;

    public function __construct(Gateway $gateway, $parameters = [])
    {
        $this->gateway = $gateway;
        $this->data = array_merge($_POST, $parameters);
        $this->isSignOk = Helper::verifySign($this->data, $this->data['sign'], $gateway->getPublicKey(), $this->data['sign_type'], Helper::TYPE_VERIFY_CONTENT_QUERY);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 获取订单号
     *
     * @return string|null
     */
    public function getOutTradeNo()
    {
        return $this->data['out_trade_no'] ?? null;
    }

    /**
     * 支付宝交易号
     *
     * @return string|null
     */
    public function getTradeNo()
    {
        return $this->data['trade_no'] ?? null;
    }

    public function getNotifyTime()
    {
        return $this->data['notify_time'] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return $this->isSignOk && ($this->data['trade_status'] == 'TRADE_FINISHED' || $this->data['trade_status'] == 'TRADE_SUCCESS');
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorCode()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessage()
    {
        return null;
    }

    /**
     * 通知成功打印结果给支付宝
     *
     * @return string
     */
    public function getSuccessResult()
    {
        return 'success';
    }

    /**
     * 通知失败打印结果给支付宝
     *
     * @return string
     */
    public function getFailResult()
    {
        return 'fail';
    }

}