<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Common\Util\Http;
use Delz\Pay\WeChat\Helper;

/**
 * 刷卡支付请求
 *
 * @package Delz\Pay\WeChat\Message
 */
class MicroOrderRequest extends Request
{
    /**
     * 提交刷卡支付API网址
     */
    const API_MICRO_PAY = 'https://api.mch.weixin.qq.com/pay/micropay';

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $response = Http::post(self::API_MICRO_PAY, ['body' => Helper::array2xml($this->getData())]);
        $data = Helper::xml2array($response->getBody());

        return new MicroOrderResponse($this, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->checkRequired(
            'app_id',
            'mch_id',
            'body',
            'out_trade_no',
            'total_fee',
            'auth_code'
        );

        $data = [
            'appid'            => $this->getAppId(),//应用ID
            'mch_id'           => $this->getMchId(),//商户号
            'device_info'      => $this->getDeviceInfo(),//设备号
            'body'             => $this->getBody(),//商品描述
            'detail'           => $this->getDetail(),//商品详情,商品详细列表，使用Json格式，传输签名前请务必使用CDATA标签将JSON文本串保护起来。
            'attach'           => $this->getAttach(),//附加数据,在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据
            'out_trade_no'     => $this->getOutTradeNo(),//商户订单号
            'fee_type'         => $this->getFeeType(),//货币类型 默认人民币：CNY
            'total_fee'        => $this->getTotalFee(),//订单总金额，单位为分
            'spbill_create_ip' => $this->getSpbillCreateIp(),//用户端实际ip
            'goods_tag'        => $this->getGoodsTag(),//商品标记，代金券或立减优惠功能的参数
            'nonce_str'        => md5(uniqid()),//随机字符串
            'auth_code'        => $this->getAuthCode(), //扫码支付授权码，设备读取用户微信中的条码或者二维码信息
        ];

        //过滤空值
        $data = array_filter($data);

        //生成签名
        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * 获取扫码支付授权码
     *
     * 设备读取用户微信中的条码或者二维码信息
     *
     * @return mixed
     */
    public function getAuthCode()
    {
        return $this->getParameter('auth_code');
    }

    /**
     * 设置扫码支付授权码
     *
     * @param mixed $authCode
     */
    public function setAuthCode($authCode)
    {
        $this->setParameter('auth_code', $authCode);
    }
}