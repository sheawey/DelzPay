<?php

namespace Delz\Pay\WeChat;

/**
 * 微信支付助手类
 * @package Delz\Pay\WeChat
 */
class Helper
{
    /**
     * 将array转化成xml字符
     * @param array $arr
     * @return string
     */
    public static function array2xml(array  $arr=[])
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     *
     * @param string $xml
     * @return array
     */
    public static function xml2array($xml)
    {
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 生成签名
     *
     * @param array $data
     * @param string $key
     * @return string
     */
    public static function sign(array $data = [], $key)
    {
        //签名不需要sign
        unset($data['sign']);
        //按字典序排序参数
        ksort($data);
        //将参数拼接成字符串
        $query = urldecode(http_build_query($data));
        //在string后加入KEY
        $query .= "&key={$key}";
        //MD5加密,所有字符转为大写
        return strtoupper(md5($query));
    }
}