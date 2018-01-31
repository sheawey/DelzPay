<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Alipay\Helper;
use Delz\Common\Util\Http;

/**
 * 统一收单交易创建
 * @package Delz\Pay\Alipay\Message
 */
class CreateOrderRequest extends Request
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->checkRequired(
            'app_id',
            'out_trade_no',
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
            'biz_content' => [
                'out_trade_no' => $this->getOutTradeNo(),
                'seller_id' => $this->getSellerId(),
                'subject' => $this->getSubject(),
                'total_amount' => $this->getTotalAmount(),
                'body' => $this->getBody(),
                'operator_id' => $this->getOperatorId(),
                'store_id' => $this->getStoreId(),
                'terminal_id' => $this->getTerminalId(),
                'timeout_express' => $this->getTimeoutExpress(),
                'buyer_id' => $this->getBuyerId()
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

        return new CreateOrderResponse($this, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return 'alipay.trade.create';
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
     * @param string $sellerId 卖家支付宝用户ID
     */
    public function setSellerId($sellerId)
    {
        $this->setParameter('seller_id', $sellerId);
    }

    /**
     * 卖家支付宝用户ID
     *
     * @return string
     */
    public function getSellerId()
    {
        return $this->getParameter('seller_id');
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
     * 买家的支付宝唯一用户号（2088开头的16位纯数字）
     *
     * @return string
     */
    public function getBuyerId()
    {
        return $this->getParameter('buyer_id');
    }

    /**
     * @param string $buyerId 买家的支付宝唯一用户号（2088开头的16位纯数字）
     */
    public function setBuyerId($buyerId)
    {
        $this->setParameter('buyer_id', $buyerId);
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
     * 商户操作员编号
     *
     * @return string
     */
    public function getOperatorId()
    {
        return $this->getParameter('operator_id');
    }

    /**
     * @param string $operatorId 商户操作员编号
     */
    public function setOperatorId($operatorId)
    {
        $this->setParameter('operator_id', $operatorId);
    }

    /**
     * 商户门店编号
     *
     * @return string
     */
    public function getStoreId()
    {
        return $this->getParameter('store_id');
    }

    /**
     * @param string $storeId 商户门店编号
     */
    public function setStoreId($storeId)
    {
        $this->setParameter('store_id', $storeId);
    }

    /**
     * 商户机具终端编号
     *
     * @return string
     */
    public function getTerminalId()
    {
        return $this->getParameter('terminal_id');
    }

    /**
     * @param string $terminalId 商户机具终端编号
     */
    public function setTerminalId($terminalId)
    {
        $this->setParameter('terminal_id', $terminalId);
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