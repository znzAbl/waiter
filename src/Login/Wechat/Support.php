<?php


namespace Waiter\Login\Wechat;

use Waiter\Contracts\LoginInterface;
use Waiter\Support\Collection;
use Waiter\Support\WechatFun;

/**
 * Class Support
 * @package Waiter\Login\Wechat
 */
class Support extends WechatFun implements LoginInterface
{
    /**
     * 普通模式.
     */
    const MODE_NORMAL = 'normal';

    /**
     * Const url.
     */
    const URL = [
        self::MODE_NORMAL => 'https://api.weixin.qq.com/',
    ];

    /**
     * Wechat payload.
     *
     * @var array
     */
    protected $load;

    /**
     * Wechat gateway.
     *
     * @var string
     */
    protected $gateway;

    /**
     * Wechat mode.
     * @var string
     */
    protected $mode;

    /**
     * Support constructor.
     * @throws \Waiter\Exceptions\InvalidConfigException
     */
    public function __construct()
    {
        $this->mode = Collection::get('config', 'mode');

        $this->gateway = self::URL[$this->mode];

        $this->load = [
            'appid' => Collection::get('config', 'app_id'),
            'secret' => Collection::get('config', 'app_secret'),
        ];
    }

    /**
     * @param $code
     * @param $refreshToken
     * @param $grantType
     * @return mixed|void
     */
    public function getToken($code, $refreshToken, $grantType)
    {

    }

    /**
     * @param $encryptedData
     * @param $iv
     * @param $sessionKey
     * @param $data
     * @return bool
     * @throws \Waiter\Exceptions\InvalidConfigException
     */
    public function decryptData($encryptedData, $iv, $sessionKey, &$data) : bool
    {
        $aesKey=base64_decode($sessionKey);
        $aesIV=base64_decode($iv);
        $aesCipher=base64_decode($encryptedData);
        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj=json_decode( $result, true);

        if($dataObj == NULL){
            return false;
        }
        if($dataObj['watermark']['appid'] != Collection::get('config', 'app_id')){
            return false;
        }
        $data = $dataObj;
        return true;
    }
}