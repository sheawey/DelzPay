<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Pay\Common\Contract\INotifyResponse;
use Delz\Pay\WeChat\Helper;

/**
 * 异步通知结果
 *
 * @package Delz\Pay\WeChat\Message
 */
class NotifyResponse extends Response implements INotifyResponse
{
    public function getData()
    {
        return array_merge($this->request->getData(), $this->data);
    }

    public function isSuccessful()
    {
        return $this->isPaid();
    }

    public function isPaid()
    {
        $data = $this->getData();
        return $data['paid'];
    }

    public function isSignMatch()
    {
        $data = $this->getData();
        return $data['sign_match'];
    }

    public function getSuccessResult()
    {
        $arr = [
            'return_code' => 'SUCCESS',
            'return_msg' => 'OK'
        ];
        return Helper::array2xml($arr);
    }

    public function getFailResult($reason = '')
    {
        $arr = [
            'return_code' => 'FAIL',
            'return_msg' => $reason
        ];
        return Helper::array2xml($arr);
    }


}