<?php

namespace Delz\Pay\Alipay;

/**
 * 支付宝助手类
 *
 * @package Delz\Pay\Alipay
 */
class Helper
{
    /**
     * 将数组形式的支付业务参数转化成json格式的字符串
     *
     * @param array $bizContent 支付业务参数
     * @return string
     */
    public static function convertBizContentToString(array $bizContent)
    {
        //去掉数组中空值
        $bizContent = array_filter($bizContent, "strlen");
        return json_encode($bizContent);
    }


    /**
     * 生成签名
     *
     * @param array $parameters 要签名的参数集合
     * @param string $key 私钥或私钥文件路径
     * @param string $type 签名类型，支持RSA和RSA2
     *
     * @return string
     * @throws \InvalidArgumentException 如果签名类型不是RSA或RSA2，抛出异常
     */
    public static function sign(array $parameters, $key, $type = 'RSA2')
    {
        //去除加密参数中的空值
        $parameters = array_filter($parameters, 'strlen');

        //去除sign键值，如果存在
        unset($parameters['sign']);

        ksort($parameters);

        //待签名的字符串
        $signStr = urldecode(http_build_query($parameters));

        switch ($type) {
            case 'RSA2':
                $alg = OPENSSL_ALGO_SHA256;
                break;
            case 'RSA':
                $alg = OPENSSL_ALGO_SHA1;
                break;
            default:
                throw new \InvalidArgumentException(
                    sprintf('Sign type of "%s" is not support.', $type)
                );
                break;
        }

        $key = self::formatPrivateKey($key);

        $privateId = openssl_pkey_get_private($key);

        $sign = '';

        openssl_sign($signStr, $sign, $privateId, $alg);
        openssl_free_key($privateId);

        return base64_encode($sign);
    }


    /**
     * 格式化私钥
     *
     * @param string $key 私钥或私钥文件路径
     * @return string
     */
    private static function formatPrivateKey($key)
    {
        if (is_file($key)) {
            return file_get_contents($key);
        }

        if (is_string($key) && strpos($key, '-----') === false) {
            $keyLines = [];
            $keyLines[] = '-----BEGIN RSA PRIVATE KEY-----';
            $i = 0;
            while ($keyStr = substr($key, $i * 64, 64)) {
                $keyLines[] = $keyStr;
                $i++;
            }
            $keyLines[] = '-----END RSA PRIVATE KEY-----';

            return implode("\n", $keyLines);

        }

        return $key;
    }
}