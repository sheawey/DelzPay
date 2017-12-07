<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Common\Util\Http;
use Delz\Pay\Alipay\Helper;
use Delz\Pay\Common\Exception\InvalidRequestException;

/**
 * 退款请求类
 *
 * @package Delz\Pay\Alipay\Message
 */
class RefundRequest extends Request
{
    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return 'alipay.trade.refund';
    }


    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->checkRequired(
            'app_id',
            'refund_amount',
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
            'biz_content' => [
                'out_trade_no' => $this->getOutTradeNo(),
                'trade_no' => $this->getTradeNo(),
                'refund_amount' => $this->getRefundAmount(),
                'refund_reason'=> $this->getRefundReason(),
                'out_request_no' => $this->getOutTradeNo(),
                'operator_id' => $this->getOperatorId(),
                'store_id' => $this->getStoreId(),
                'terminal_id' => $this->getTerminalId()
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

        return new RefundResponse($this, $data);
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

    /**
     * 需要退款的金额
     *
     * 该金额不能大于订单金额,单位为元，支持两位小数
     *
     * @return float
     */
    public function getRefundAmount()
    {
        return $this->getParameter('refund_amount');
    }

    /**
     * @param float $refundAmount 需要退款的金额
     */
    public function setRefundAmount($refundAmount)
    {
        $this->setParameter('refund_amount', $refundAmount);
    }

    /**
     * 退款的原因说明
     *
     * @return string
     */
    public function getRefundReason()
    {
        return $this->getParameter('refund_reason');
    }

    /**
     * @param string $refundReason 退款的原因说明
     */
    public function setRefundReason($refundReason)
    {
        $this->setParameter('refund_reason', $refundReason);
    }

    /**
     * 商户退款单号
     *
     * 同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
     *
     * @return string
     */
    public function getOutRequestNo()
    {
        return $this->getParameter('out_request_no');
    }

    /**
     * @param string $outRequestNo 商户退款单号
     */
    public function setOutRequestNo($outRequestNo)
    {
        $this->setParameter('out_request_no', $outRequestNo);
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
}