<?php


namespace Waiter\Support;

use Waiter\Payment\Payment;
use Waiter\Login\Login;

/**
 * Class Alipay
 * @method Payment Payment() 支付宝支付
 * @method Login Login() 支付宝登陆
 * @package Waiter
 */
class Alipay extends EntranceIdentifier
{
    /**
     * @return string
     */
    public static function getAssembly()
    {
        return 'Alipay';
    }

}