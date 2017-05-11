<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Common\Util\Http;
use Delz\Pay\WeChat\Helper;

/**
 * 退款请求
 *
 * @package Delz\Pay\WeChat\Message
 */
class RefundOrderRequest extends Request
{
    /**
     * 关闭订单网址
     */
    const API_REFUND_ORDER = 'https://api.mch.weixin.qq.com/secapi/pay/refund';

    public function send()
    {
        $response = Http::post(self::API_REFUND_ORDER, [
            'body'=> Helper::array2xml($this->getData()),
            'ssl_key' => $this->getKeyPath(),
            'cert' => $this->getCertPath()
        ]);
        $data = Helper::xml2array($response->getBody());

        return new RefundOrderResponse($this, $data);
    }

    public function getData()
    {
        $this->checkRequired('app_id', 'mch_id', 'out_trade_no', 'cert_path', 'key_path');

        $data = array (
            'appid'           => $this->getAppId(),
            'mch_id'          => $this->getMchId(),
            'device_info'     => $this->getDeviceInfo(),
            'transaction_id'  => $this->getTransactionId(),
            'out_trade_no'    => $this->getOutTradeNo(),
            'out_refund_no'   => $this->getOutRefundNo(),
            'total_fee'       => $this->getTotalFee(),
            'refund_fee'      => $this->getRefundFee(),
            'refund_fee_type' => $this->getRefundFeeType(),
            'op_user_id'      => $this->getOpUserId() ?: $this->getMchId(),
            'nonce_str'       => md5(uniqid()),
        );
        $data = array_filter($data);
        $data['sign'] = Helper::sign($data, $this->getApiKey());
        return $data;
    }

    /**
     * 获取操作员帐号
     *
     * @return string
     */
    public function getOpUserId()
    {
        return $this->getParameter('op_user_id');
    }

    /**
     * 设置操作员帐号
     *
     * @param string $opUserId
     */
    public function setOpUserId($opUserId)
    {
        $this->setParameter('op_user_id', $opUserId);
    }

    /**
     * 获取商户退款单号
     *
     * @return string
     */
    public function getOutRefundNo()
    {
        return $this->getParameter('out_refund_no');
    }

    /**
     * 设置商户退款单号
     *
     * @param string $outRefundNo
     */
    public function setOutRefundNo($outRefundNo)
    {
        $this->setParameter('out_refund_no', $outRefundNo);
    }

    /**
     * 获取微信订单号
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getParameter('transaction_id');
    }

    /**
     * 设置微信订单号
     *
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->setParameter('transaction_id', $transactionId);
    }

    /**
     * 获取退款金额，单位为分
     *
     * @return int
     */
    public function getRefundFee()
    {
        return $this->getParameter('refund_fee');
    }

    /**
     * 设置退款金额，单位为分
     *
     * @param int $refundFee
     */
    public function setRefundFee($refundFee)
    {
        $this->setParameter('refund_fee', $refundFee);
    }

    /**
     * 获取货币种类
     *
     * @return string
     */
    public function getRefundFeeType()
    {
        return $this->getParameter('refund_fee_type');
    }

    /**
     * 设置货币种类
     *
     * @param string $refundFeeType
     */
    public function setRefundFeeType($refundFeeType)
    {
        $this->setParameter('refund_fee_type', $refundFeeType);
    }

    /**
     * 获取证书路径
     *
     * @return string
     */
    public function getCertPath()
    {
        return $this->getParameter('cert_path');
    }

    /**
     * 设置证书路径
     *
     * @param string $certPath
     */
    public function setCertPath($certPath)
    {
        $this->setParameter('cert_path', $certPath);
    }

    /**
     * 获取证书秘钥路径
     *
     * @return string
     */
    public function getKeyPath()
    {
        return $this->getParameter('key_path');
    }

    /**
     * 设置证书秘钥路径
     *
     * @param string $keyPath
     */
    public function setKeyPath($keyPath)
    {
        $this->setParameter('key_path', $keyPath);
    }

}