<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Alipay\Helper;
use Delz\Common\Util\Http;

/**
 * PC场景下单请求类
 *
 * @package Delz\Pay\Alipay\Message
 */
class CreatePageOrderRequest extends Request
{
    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return 'alipay.trade.page.pay';
    }


    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->checkRequired(
            'app_id',
            'out_trade_no',
            'notify_url',
            'total_amount',
            'charset',
            'sign_type',
            'private_key',
            'public_key'
        );

        $data = [
            'app_id' => $this->getAppId(),
            'method' => $this->getMethod(),
            'format' => $this->getFormat(),
            'charset' => $this->getCharset(),
            'sign_type' => $this->getSignType(),
            'timestamp' => $this->getTimestamp(),
            'version' => $this->getVersion(),
            'notify_url' => $this->getNotifyUrl(),
            'return_url' => $this->getReturnUrl(),
            'biz_content' => [
                'out_trade_no' => $this->getOutTradeNo(),
                'product_code' => $this->getProductCode(),
                'subject' => $this->getSubject(),
                'total_amount' => $this->getTotalAmount(),
                'body' => $this->getBody(),
                'timeout_express' => $this->getTimeoutExpress()
            ]
        ];

        //将biz_content转化成string
        $data['biz_content'] = Helper::convertBizContentToString($data['biz_content']);

        //去除空值
        $data = array_filter($data, 'strlen');

        $data['sign'] = Helper::sign($data, $this->getPrivateKey(), $this->getSignType());

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        return Http::post(self::GATEWAY_URL, ['form_params' => $this->getData()]);
    }

    /**
     * 设置商户订单号
     *
     * 64个字符以内、可包含字母、数字、下划线；需保证在商户端不重复
     *
     * @param string $outTradeNo 商户订单号
     */
    public function setOutTradeNo($outTradeNo)
    {
        $this->setParameter('out_trade_no', $outTradeNo);
    }

    /**
     * 获取商户订单号
     *
     * @return string
     */
    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }

    /**
     * @param string $returnUrl 支付宝服务器主动通知商户服务器里指定的页面http/https路径。
     */
    public function setReturnUrl($returnUrl)
    {
        $this->setParameter('return_url', $returnUrl);
    }

    /**
     * 支付宝服务器主动通知商户服务器里指定的页面http/https路径。
     *
     * @return string|null
     */
    public function getReturnUrl()
    {
        return $this->getParameter('return_url');
    }

    /**
     * 销售产品码，与支付宝签约的产品码名称。
     *
     * 目前仅支持FAST_INSTANT_TRADE_PAY
     *
     * @return string
     */
    public function getProductCode()
    {
        return 'FAST_INSTANT_TRADE_PAY';
    }

    /**
     * 订单标题
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->getParameter('subject') ?: $this->getOutTradeNo();
    }

    /**
     * @param string $subject 订单标题
     */
    public function setSubject($subject)
    {
        $this->setParameter('subject', $subject);
    }

    /**
     * 订单总金额，单位为元
     *
     * 精确到小数点后两位，取值范围[0.01,100000000]
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->getParameter('total_amount');
    }

    /**
     * @param float $totalAmount 订单总金额
     */
    public function setTotalAmount($totalAmount)
    {
        $this->setParameter('total_amount', $totalAmount);
    }

    /**
     * 订单描述
     *
     * @return string
     */
    public function getBody()
    {
        return $this->getParameter('body');
    }

    /**
     * @param string $body 订单描述
     */
    public function setBody($body)
    {
        $this->setParameter('body', $body);
    }

    /**
     * 订单允许的最晚付款时间
     *
     * 取值范围：1m～15d。
     * m-分钟，h-小时，d-天，1c-当天
     * （1c-当天的情况下，无论交易何时创建，都在0点关闭）。
     * 该参数数值不接受小数点， 如 1.5h，可转换为 90m
     *
     * @return string
     */
    public function getTimeoutExpress()
    {
        return $this->getParameter('timeout_express');
    }

    /**
     * @param string $timeoutExpress 订单允许的最晚付款时间
     */
    public function setTimeoutExpress($timeoutExpress)
    {
        $this->setParameter('timeout_express', $timeoutExpress);
    }
}