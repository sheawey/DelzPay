<?php

namespace Delz\Pay\Common;

use Delz\Pay\Common\Contract\IRequest;
use Delz\Pay\Common\Contract\IResponse;

/**
 * 支付返回结果抽象类
 *
 * @package Delz\Pay\Common
 */
abstract class Response implements IResponse
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var IRequest
     */
    protected $request;

    public function __construct(IRequest $request, $data)
    {
        $this->data = $data;
        $this->request = $request;
    }

    public function getData()
    {
        return $this->data;
    }
}