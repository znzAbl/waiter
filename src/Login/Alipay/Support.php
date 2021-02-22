<?php


namespace Waiter\Login\Alipay;


use Waiter\Contracts\LoginInterface;
use Waiter\Support\AlipayFun;
use Waiter\Support\Collection;

class Support extends AlipayFun implements LoginInterface
{
    /**
     * 普通模式.
     */
    const MODE_NORMAL = 'normal';

    /**
     * Const url.
     */
    const URL = [
        self::MODE_NORMAL => 'https://openapi.alipay.com/gateway.do?charset=utf-8',
    ];

    /**
     * Alipay load.
     *
     * @var array
     */
    protected $load;

    /**
     * Alipay gateway.
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
            'app_id' => Collection::get('config', 'app_id'),
            'format' => 'JSON',
            'charset' => 'utf-8',
            'sign_type' => 'RSA2',
            'version' => '1.0',
            'timestamp' => date('Y-m-d H:i:s'),
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
     * 解密密文
     * @param string $encryptedData
     * @return array
     */
    public function decryptData(string $encryptedData) : array
    {
        $aesKey = Collection::get('config', 'aes_key');
        return json_decode(openssl_decrypt(base64_decode($encryptedData), 'AES-128-CBC', base64_decode($aesKey),OPENSSL_RAW_DATA), true);
    }

}