<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Pay\Common\Exception\InvalidRequestException;
use Delz\Pay\WeChat\Helper;
use Delz\Common\Util\Http;

/**
 * 退款请求
 * @package Delz\Pay\WeChat\Message
 */
class QueryRefundRequest extends Request
{
    /**
     * 查询退款网址
     */
    const API_REFUND_QUERY = 'https://api.mch.weixin.qq.com/pay/refundquery';

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $this->checkRequired(
            'app_id',
            'mch_id'
        );

        if(!$this->getOutTradeNo() && !$this->getTransactionId() && !$this->getOutRefundNo() && !$this->getRefundId()) {
            throw new InvalidRequestException("The 'transaction_id' or 'out_trade_no' or 'refund_id' or 'out_refund_no' parameter is required");
        }

        $data = array (
            'appid'          => $this->getAppId(),
            'mch_id'         => $this->getMchId(),
            'out_refund_no' => $this->getOutRefundNo(),
            'out_trade_no'   => $this->getOutTradeNo(),
            'nonce_str'      => md5(uniqid()),
        );

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
        $response = Http::post(self::API_REFUND_QUERY, ['body' => Helper::array2xml($this->getData())]);
        $data = Helper::xml2array($response->getBody());

        return new QueryRefundResponse($this, $data);
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getParameter('transaction_id');
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->setParameter('transaction_id', $transactionId);
    }

    /**
     * @return string
     */
    public function getOutRefundNo()
    {
        return $this->getParameter('out_refund_no');
    }

    /**
     * @param string $outRefundNo
     */
    public function setOutRefundNo($outRefundNo)
    {
        $this->setParameter('out_refund_no', $outRefundNo);
    }

    /**
     * @return string
     */
    public function getRefundId()
    {
        return $this->getParameter('refund_id');
    }

    /**
     * @param string $refundId
     */
    public function setRefundId($refundId)
    {
        $this->setParameter('refund_id', $refundId);
    }


}