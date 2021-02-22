<?php


namespace Waiter\Support;

/**
 * Class HttpClient
 * @package Waiter\Support
 */
class HttpClient
{
    /**
     * @param $url
     * @param string $method
     * @param array $data
     * @param int $second
     * @return bool|string
     */
    public static function request($url, $method = 'POST', $data = [], $second = 30)
    {
        $method = strtoupper($method);
        //初始化
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //设置请求地址
        curl_setopt($ch, CURLOPT_URL, $url);
        // 检查ssl证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 从检查本地证书检查是否ssl加密
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        //设置请求数据
        if ($method == 'POST' && !empty($data)) {
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}