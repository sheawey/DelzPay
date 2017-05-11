<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Pay\Common\Exception\InvalidRequestException;
use Delz\Pay\WeChat\Helper;

/**
 * 异步通知请求
 *
 * @package Delz\Pay\WeChat\Message
 */
class NotifyRequest extends Request
{
    public function send()
    {
        $data = $this->getData();

        if(!$data) {
            throw new InvalidRequestException('invalid notify data');
        }

        $sign = Helper::sign($data, $this->getApiKey());

        $responseData = array();
        if (isset($data['sign']) && $data['sign'] && $sign === $data['sign']) {
            $responseData['sign_match'] = true;
        } else {
            $responseData['sign_match'] = false;
        }
        if ($responseData['sign_match'] && isset($data['result_code']) && $data['result_code'] == 'SUCCESS') {
            $responseData['paid'] = true;
        } else {
            $responseData['paid'] = false;
        }

        return new NotifyResponse($this, $responseData);
    }

    public function getData()
    {
        $data = $this->getRequestParams();
        if (is_string($data)) {
            $data = Helper::xml2array($data);
        }

        return $data;
    }

    public function setRequestParams($requestParams)
    {
        $this->setParameter('request_params', $requestParams);
    }

    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }
}