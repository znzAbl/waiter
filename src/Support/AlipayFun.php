<?php


namespace Waiter\Support;

use Waiter\Exceptions\InvalidResultException;

class AlipayFun
{

    /**
     * @param array $params
     * @return string
     * @throws \Waiter\Exceptions\InvalidConfigException
     */
    protected static function generateSign(array $params): string
    {
        $privateKey = Collection::get('config', 'private_key');
        if (Str::endsWith($privateKey, '.pem')) {
            $privateKey = openssl_pkey_get_private(
                Str::startsWith($privateKey, 'file://') ? $privateKey : 'file://'.$privateKey
            );
        } else {
            $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n".
                wordwrap($privateKey, 64, "\n", true).
                "\n-----END RSA PRIVATE KEY-----";
        }
        openssl_sign(self::getSignContent($params), $sign, $privateKey, OPENSSL_ALGO_SHA256);

        $sign = base64_encode($sign);

        if (is_resource($privateKey)) {
            openssl_free_key($privateKey);
        }

        return $sign;
    }

    /**
     * @param array $data
     * @return array
     */
    protected static function filter(array $data) : array
    {
        return array_filter($data, function ($value) {
            return ('' == $value || is_null($value)) ? false : true;
        });
    }

    /**
     * @param $result
     * @return array
     */
    protected function processingApiResult($load, $result) : array
    {
        $result = json_decode($result, true);

        if($result == NULL){
            throw new InvalidResultException('Not a standard JSON', $result);
        }

        $method = str_replace('.', '_', $load['method']) . '_response';

        if(!isset($result[$method])){
            throw new InvalidResultException('Get Alipay API Error:'. $result['error_response']['msg']);
        }

        if(stripos($load['method'], 'system') !== false){
            return $result[$method];
        }

        if (!isset($result['sign']) || '10000' != $result[$method]['code']) {
            throw new InvalidResultException('Get Alipay API Error:'.$result[$method]['msg'], $result);
        }

        if (self::verifySign($result[$method], true, $result['sign'])) {
            return $result[$method];
        }

        throw new InvalidResultException('Results the verification failed');
    }

    /**
     * @param array $data
     * @param bool $sync
     * @param null $sign
     * @return bool
     * @throws \Waiter\Exceptions\InvalidConfigException
     */
    public static function verifySign(array $data, $sync = false, $sign = null): bool
    {
        $publicKey = Collection::get('config', 'public_key');

        if (Str::endsWith($publicKey, '.crt')) {
            $publicKey = file_get_contents($publicKey);
        } elseif (Str::endsWith($publicKey, '.pem')) {
            $publicKey = openssl_pkey_get_public(
                Str::startsWith($publicKey, 'file://') ? $publicKey : 'file://'.$publicKey
            );
        } else {
            $publicKey = "-----BEGIN PUBLIC KEY-----\n".
                wordwrap($publicKey, 64, "\n", true).
                "\n-----END PUBLIC KEY-----";
        }

        $sign = $sign ?? $data['sign'];

        $toVerify = $sync ? json_encode($data, JSON_UNESCAPED_UNICODE) : self::getSignContent($data, true);

        $isVerify = 1 === openssl_verify($toVerify, base64_decode($sign), $publicKey, OPENSSL_ALGO_SHA256);

        if (is_resource($publicKey)) {
            openssl_free_key($publicKey);
        }

        return $isVerify;
    }

    /**
     * Get signContent that is to be signed.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @param bool $verify
     */
    public static function getSignContent(array $data, $verify = false): string
    {
        ksort($data);

        $stringToBeSigned = '';
        foreach ($data as $k => $v) {
            if ($verify && 'sign' != $k && 'sign_type' != $k) {
                $stringToBeSigned .= $k.'='.$v.'&';
            }
            if (!$verify && '' !== $v && !is_null($v) && 'sign' != $k && '@' != substr($v, 0, 1)) {
                $stringToBeSigned .= $k.'='.$v.'&';
            }
        }
        return trim($stringToBeSigned, '&');
    }
}