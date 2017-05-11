<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Pay\WeChat\Helper;
use Delz\Common\Util\Http;

/**
 * 关闭订单请求
 *
 * @package Delz\Pay\WeChat\Message
 */
class CloseOrderRequest extends Request
{
    /**
     * 关闭订单网址
     */
    const API_CLOSE_ORDER = 'https://api.mch.weixin.qq.com/pay/closeorder';

    public function send()
    {
        $response = Http::post(self::API_CLOSE_ORDER, ['body' => Helper::array2xml($this->getData())]);
        $data = Helper::xml2array($response->getBody());

        return new CreateOrderResponse($this, $data);
    }

    public function getData()
    {
        $this->checkRequired('app_id', 'mch_id', 'out_trade_no');

        $data = array(
            'appid' => $this->getAppId(),
            'mch_id' => $this->getMchId(),
            'out_trade_no' => $this->getOutTradeNo(),
            'nonce_str' => md5(uniqid()),
        );

        //过滤空值
        $data = array_filter($data);

        //生成签名
        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }

}