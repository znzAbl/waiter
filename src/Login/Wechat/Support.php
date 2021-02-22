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
}