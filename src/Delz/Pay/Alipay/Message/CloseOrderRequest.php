<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Exception\InvalidRequestException;
USE Delz\Pay\Alipay\Helper;
use Delz\Common\Util\Http;

/**
 * 统一收单交易关闭接口请求类
 *
 * @package Delz\Pay\Alipay\Message
 */
class CloseOrderRequest extends Request
{
    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return 'alipay.trade.close';
    }


    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->checkRequired(
            'app_id',
            'out_trade_no',
            'charset',
            'sign_type',
            'private_key',
            'public_key'
        );

        if (is_null($this->getTradeNo() && is_null($this->getOutTradeNo()))) {
            throw new InvalidRequestException('out_trade_no or trade_no have to have a non-null');
        }

        $data = [
            'app_id' => $this->getAppId(),
            'method' => $this->getMethod(),
            'format' => $this->getFormat(),
            'charset' => $this->getCharset(),
            'sign_type' => $this->getSignType(),
            'timestamp' => $this->getTimestamp(),
            'version' => $this->getVersion(),
            'notify_url' => $this->getNotifyUrl(),
            'biz_content' => [
                'out_trade_no' => $this->getOutTradeNo(),
                'trade_no' => $this->getTradeNo()
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
        $response = Http::post(self::GATEWAY_URL, ['form_params' => $this->getData()]);
        //支付宝默认返回是GBK编码，所以转化
        $body = iconv('GBK', 'UTF-8//IGNORE', $response->getBody());
        $data = json_decode($body, true);

        return new CloseOrderResponse($this, $data);
    }

    /**
     * 订单支付时传入的商户订单号
     *
     * @param string $outTradeNo 商户订单号
     */
    public function setOutTradeNo($outTradeNo)
    {
        $this->setParameter('out_trade_no', $outTradeNo);
    }

    /**
     * 订单支付时传入的商户订单号
     *
     * @return string
     */
    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }

    /**
     * 支付宝交易号
     *
     * @return string
     */
    public function getTradeNo()
    {
        return $this->getParameter('trade_no');
    }

    /**
     * @param string $tradeNo 支付宝交易号
     */
    public function setTradeNo($tradeNo)
    {
        $this->setParameter('trade_no', $tradeNo);
    }
}