<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Exception\InvalidRequestException;
use Delz\Pay\Common\Request as BaseRequest;

/**
 * 支付宝请求抽象类
 *
 * @package Delz\Pay\Alipay\Message
 */
abstract class Request extends BaseRequest
{
    /**
     * 支付宝网关（固定）
     */
    const GATEWAY_URL = 'https://openapi.alipay.com/gateway.do';

    /**
     * {@inheritdoc}
     */
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);

        if(!$this->hasParameter('charset')) {
            $this->setCharset('UTF-8');
        }

        if(!$this->hasParameter('sign_type')) {
            $this->setSignType('RSA2');
        }
    }

    /**
     * 获取支付宝分配给开发者的应用ID
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->getParameter('app_id');
    }

    /**
     * 私钥或私钥文件路径
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }

    /**
     * 公钥或公钥文件路径
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->getParameter('public_key');
    }

    /**
     * 获取调用的接口版本，固定为：1.0
     *
     * @return string
     */
    public function getVersion()
    {
        return '1.0';
    }

    /**
     * 获取发送请求的时间
     *
     * 格式"yyyy-MM-dd HH:mm:ss"
     *
     * @return string
     */
    public function getTimestamp()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * 仅支持JSON
     *
     * @return string
     */
    public function getFormat()
    {
        return 'JSON';
    }


    /**
     * 获取请求使用的编码格式，如utf-8,gbk,gb2312等
     *
     * @return string
     */
    public function getCharset()
    {
        return  $this->getParameter('charset');
    }

    /**
     * 设置请求使用的编码格式，如utf-8,gbk,gb2312等
     *
     * @param string $charset
     */
    public function setCharset($charset)
    {
        $this->setParameter('charset', $charset);
    }

    /**
     * 获取商户生成签名字符串所使用的签名算法类型，目前支持RSA2和RSA
     *
     * 默认使用RSA2
     *
     * @return string
     */
    public function getSignType()
    {
        return $this->hasParameter('sign_type') ? $this->getParameter('sign_type') : 'RSA2';
    }

    /**
     * 设置商户生成签名字符串所使用的签名算法类型，目前支持RSA2和RSA
     *
     * @param string $signType
     * @throws InvalidRequestException
     */
    public function setSignType($signType)
    {
        $signType = strtoupper($signType);
        if(!in_array($signType,['RSA2','RSA'])) {
            throw new InvalidRequestException(
                sprintf('Invalid sign type: "%s". Only support "RSA2" or "RSA".', $signType)
            );
        }
        $this->setParameter('sign_type', strtoupper($signType));
    }

    /**
     * 获取应用授权token
     *
     * @return string
     */
    public function getAppAuthToken()
    {
        return $this->getParameter('app_auth_token');
    }

    /**
     * 设置应用授权token
     *
     * @param string $appAuthToken
     */
    public function setAppAuthToken($appAuthToken)
    {
        $this->setParameter('app_auth_token', $appAuthToken);
    }

    /**
     * 支付宝服务器主动通知商户服务器里指定的页面http/https路径
     *
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }

    /**
     * @param string $notifyUrl 支付宝服务器主动通知商户服务器里指定的页面http/https路径
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->setParameter('notify_url', $notifyUrl);
    }

    /**
     * 获取接口名称
     *
     * @return string
     */
    abstract public function getMethod();
}