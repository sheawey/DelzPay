<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Pay\Common\Exception\PayException;
use Delz\Pay\WeChat\Helper;

/**
 * 预付单请求返回结果
 *
 * @package Delz\Pay\WeChat\Message
 */
class CreateOrderResponse extends Response
{
    /**
     * 获取预付单后需请求的参数，App和Js是不一样的
     *
     * @return array|null
     * @throws PayException
     */
    public function getData()
    {
        if (!$this->isSuccessful()) {
            throw new PayException($this->getErrorCode() . ': ' . $this->getErrorMessage());
        }

        if ($this->data['trade_type'] == 'APP') {
            return $this->getAppData();
        }

        if ($this->data['trade_type'] == 'JSAPI') {
            return $this->getJsData();
        }
    }

    /**
     * 获取App支付请求参数
     *
     * @return array
     */
    private function getAppData()
    {
        $data = array(
            'appid' => $this->request->getAppId(),
            'partnerid' => $this->request->getMchId(),
            'prepayid' => $this->data['prepay_id'],
            'package' => 'Sign=WXPay',
            'noncestr' => md5(uniqid()),
            'timestamp' => time(),
        );

        $data['sign'] = Helper::sign($data, $this->request->getApiKey());

        return $data;
    }

    /**
     * 获取公众号或者小程序支付请求参数
     *
     * @return array
     */
    private function getJsData()
    {
        $data = array(
            'appId' => $this->request->getAppId(),
            'package' => 'prepay_id=' . $this->data['prepay_id'],
            'nonceStr' => md5(uniqid()),
            'timeStamp' => (string)time(),
            'signType' => 'MD5',
        );
        $data['paySign'] = Helper::sign($data, $this->request->getApiKey());

        return $data;
    }

}