<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Common\Util\Http;
use Delz\Pay\WeChat\Helper;

/**
 * 生成预付单请求
 *
 * @package Delz\Pay\WeChat\Message
 */
class CreateOrderRequest extends Request
{
    /**
     * 统一下单接口网址
     */
    const API_UNIFIEORDER = 'https://api.mch.weixin.qq.com/pay/unifiedorder';

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
            'notify_url',
            'trade_type',
            'spbill_create_ip'
        );

        $tradeType = strtoupper($this->getTradeType());

        //公众号支付，须有open_id
        if ($tradeType == 'JSAPI') {
            $this->checkRequired('open_id');
        }

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
            'time_start'       => $this->getTimeStart(),//订单生成时间，格式为yyyyMMddHHmmss
            'time_expire'      => $this->getTimeExpire(),//订单失效时间，格式为yyyyMMddHHmmss
            'goods_tag'        => $this->getGoodsTag(),//商品标记，代金券或立减优惠功能的参数
            'notify_url'       => $this->getNotifyUrl(), //接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。
            'trade_type'       => $this->getTradeType(), //支付类型
            'limit_pay'        => $this->getLimitPay(),//指定支付方式,如no_credit--指定不能使用信用卡支付
            'openid'           => $this->getOpenId(),//trade_type=JSAPI时需要的参数
            'nonce_str'        => md5(uniqid()),//随机字符串
        ];

        //过滤空值
        $data = array_filter($data);

        //生成签名
        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;

    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        $response = Http::post(self::API_UNIFIEORDER, ['body' => Helper::array2xml($this->getData())]);
        $data = Helper::xml2array($response->getBody());

        return new CreateOrderResponse($this, $data);
    }

    /**
     * 获取支付类型
     *
     * @return string
     */
    public function getTradeType()
    {
        return $this->getParameter('trade_type');
    }

    /**
     * 获取
     *
     * @return string
     */
    public function getTimeStart()
    {
        return $this->getParameter('time_start');
    }

    /**
     * 获取
     *
     * @return string
     */
    public function getTimeExpire()
    {
        return $this->getParameter('time_expire');
    }

    /**
     * 获取
     *
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }

    /**
     * 获取
     *
     * @return string
     */
    public function getLimitPay()
    {
        return $this->getParameter('limit_pay');
    }

    /**
     * 获取
     *
     * @return string
     */
    public function getOpenId()
    {
        return $this->getParameter('open_id');
    }

    /**
     * 设置
     *
     * @param string $timeStart
     */
    public function setTimeStart($timeStart)
    {
        $this->setParameter('time_start', $timeStart);
    }

    /**
     * 设置
     *
     * @param string $timeExpire
     */
    public function setTimeExpire($timeExpire)
    {
        $this->setParameter('time_expire', $timeExpire);
    }

    /**
     * 设置
     *
     * @param string $notifyUrl
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->setParameter('notify_url', $notifyUrl);
    }

    /**
     * 设置
     *
     * @param string $tradeType
     */
    public function setTradeType($tradeType)
    {
        $this->setParameter('trade_type', $tradeType);
    }

    /**
     * 设置
     *
     * @param string $limitPay
     */
    public function setLimitPay($limitPay)
    {
        $this->setParameter('limit_pay', $limitPay);
    }

    /**
     * 设置
     *
     * @param string $openId
     */
    public function setOpenId($openId)
    {
        $this->setParameter('open_id', $openId);
    }

}