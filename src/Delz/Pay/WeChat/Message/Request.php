<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Pay\Common\Request as BaseRequest;

/**
 * @package Delz\Pay\WeChat\Message
 */
abstract class Request extends BaseRequest
{
    /**
     * 获取
     *
     * @return mixed
     */
    public function getAppId()
    {
        return $this->getParameter('app_id');
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId)
    {
        $this->setParameter('app_id', $appId);
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getParameter('api_key');
    }

    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->setParameter('api_key', $apiKey);
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getMchId()
    {
        return $this->getParameter('mch_id');
    }

    /**
     * @param mixed $mchId
     */
    public function setMchId($mchId)
    {
        $this->setParameter('mch_id', $mchId);
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getDeviceInfo()
    {
        return $this->getParameter('device_Info');
    }

    /**
     * @param mixed $deviceInfo
     */
    public function setDeviceInfo($deviceInfo)
    {
        $this->setParameter('device_Info', $deviceInfo);
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->getParameter('body');
    }

    /**
     *
     *
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->setParameter('body', $body);
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getDetail()
    {
        return $this->getParameter('detail');
    }

    /**
     * @param mixed $detail
     */
    public function setDetail($detail)
    {
        $this->setParameter('detail', $detail);
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getAttach()
    {
        return $this->getParameter('attach');
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getFeeType()
    {
        return $this->getParameter('fee_type');
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getTotalFee()
    {
        return $this->getParameter('total_fee');
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getSpbillCreateIp()
    {
        return $this->getParameter('spbill_create_ip');
    }

    /**
     * @param mixed $attach
     */
    public function setAttach($attach)
    {
        $this->setParameter('attach', $attach);
    }

    /**
     * @param mixed $outTradeNo
     */
    public function setOutTradeNo($outTradeNo)
    {
        $this->setParameter('out_trade_no', $outTradeNo);
    }

    /**
     * @param mixed $feeType
     */
    public function setFeeType($feeType)
    {
        $this->setParameter('fee_type', $feeType);
    }

    /**
     * @param mixed $totalFee
     */
    public function setTotalFee($totalFee)
    {
        $this->setParameter('total_fee', $totalFee);
    }

    /**
     * @param mixed $spbillCreateIp
     */
    public function setSpbillCreateIp($spbillCreateIp)
    {
        $this->setParameter('spbill_create_ip', $spbillCreateIp);
    }

    /**
     * 获取
     *
     * @return mixed
     */
    public function getGoodsTag()
    {
        return $this->getParameter('goods_tag');
    }

    /**
     * @param mixed $goodsTag
     */
    public function setGoodsTag($goodsTag)
    {
        $this->setParameter('goods_tag', $goodsTag);
    }

}