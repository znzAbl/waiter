<?php


namespace Waiter\Support;

use Waiter\Payment\Payment;
use Waiter\Login\Login;

/**
 * Class Wechat
 * @method Payment Payment() 微信支付
 * @method Login Login() 微信登陆
 * @package Waiter
 */
class Wechat extends EntranceIdentifier
{
    /**
     * @return string
     */
    public static function getAssembly()
    {
        return 'Wechat';
    }
}