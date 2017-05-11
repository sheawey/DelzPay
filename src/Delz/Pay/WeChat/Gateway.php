<?php

namespace Delz\Pay\WeChat;

use Delz\Pay\Common\Gateway as BaseGateway;

/**
 * 微信支付抽象类
 *
 * @package Delz\Pay\Delz
 */
abstract class Gateway extends BaseGateway
{
    public function getTradeType()
    {
        return $this->getParameter("trade_type");
    }

    public function setTradeType($tradeType)
    {
        $this->setParameter("trade_type", $tradeType);
    }

    public function getAppId()
    {
        return $this->getParameter("app_id");
    }

    public function setAppId($appId)
    {
        $this->setParameter("app_id", $appId);
    }

    public function getMchId()
    {
        return $this->getParameter("mch_id");
    }

    public function setMchId($mchId)
    {
        $this->setParameter("mch_id", $mchId);
    }

    public function getApiKey()
    {
        return $this->getParameter("api_key");
    }

    public function setApiKey($apiKey)
    {
        $this->setParameter('api_key', $apiKey);
    }

    public function getNotifyUrl()
    {
        return $this->getParameter("notify_url");
    }

    public function setNotifyUrl($url)
    {
        $this->setParameter('notify_url', $url);
    }

    public function getCertPath()
    {
        return $this->getParameter("cert_path");
    }

    public function setCertPath($certPath)
    {
        $this->setParameter("cert_path", $certPath);
    }

    public function getKeyPath()
    {
        return $this->getParameter("key_path");
    }

    public function setKeyPath($keyPath)
    {
        $this->setParameter("key_path", $keyPath);
    }

    public function purchase(array $parameters = [])
    {
        $parameters['trade_type'] = $this->getTradeType();

        return $this->createRequest('\Delz\Pay\WeChat\Message\CreateOrderRequest', $parameters);
    }

    public function notify(array $parameters = [])
    {
        $parameters['request_params'] = file_get_contents('php://input');

        return $this->createRequest('\Delz\Pay\WeChat\Message\NotifyRequest',$parameters);
    }

    public function query(array $parameters = [])
    {
        return $this->createRequest('\Delz\Pay\WeChat\Message\QueryOrderRequest',$parameters);
    }

    public function close(array $parameters = [])
    {
        return $this->createRequest('\Delz\Pay\WeChat\Message\CloseOrderRequest',$parameters);
    }

    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Delz\Pay\WeChat\Message\RefundOrderRequest',$parameters);
    }

    public function queryRefund(array $parameters = [])
    {
        return $this->createRequest('\Delz\Pay\WeChat\Message\QueryRefundRequest',$parameters);
    }


}