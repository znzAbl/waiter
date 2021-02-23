<?php


namespace Waiter\Payment\Wechat;

use Waiter\Support\Collection;
use Waiter\Exceptions\InvalidParameterException;

/**
 * Class Mini
 * @package Waiter\Payment\Wechat
 */
class Mini extends Support
{

    /**
     * @param array $order
     * @return array|mixed|void|InvalidParameterException
     * @throws \Waiter\Exceptions\InvalidConfigException
     */
    public function pay(array $order)
    {
        if(empty($order)){
            return new InvalidParameterException('Order data cannot be empty');
        }
        $load = array_merge($this->payload, $order);
        $load['trade_type'] = $this->getTradeType();

        $retult = $this->preOrder($load);

        $payRequest = [
            'appId'     => $load['appid'],
            'timeStamp' => strval(time()),
            'nonceStr'  => $load['nonce_str'],
            'package'   => 'prepay_id=' . $retult['prepay_id'],
            'signType'  => $this->payload['sign_type'],
        ];
        $payRequest['paySign'] = self::generateSign($payRequest);
        $payRequest['sign']    = $retult['sign'];
        return $payRequest;
    }

    /**
     * Get trade type config.
     *
     * @author znzAbl <znz_abl@qq.com>
     */
    protected function getTradeType(): string
    {
        return 'JSAPI';
    }
}