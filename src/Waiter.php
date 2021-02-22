<?php


namespace Waiter;

use Waiter\Support\Alipay;
use Waiter\Support\Wechat;

/**
 * Class Waiter
 * @package Waiter
 */
class Waiter
{
    /**
     * @param array $config
     * @return Wechat
     */
    public static function Wechat(array $config) : Wechat
    {
        return new Wechat($config);
    }

    /**
     * @param array $config
     * @return Alipay
     */
    public static function Alipay(array $config) : Alipay
    {
        return new Alipay($config);
    }
}