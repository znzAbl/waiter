<?php

namespace Waiter\Payment\Alipay;

use Waiter\Support\HttpClient;
use Waiter\Exceptions\InvalidParameterException;

/**
 * Class Mini
 * @package Waiter\Payment\Alipay
 */
class Mini extends Support
{
    /**
     * @param array $order
     * @return array|mixed|void
     * @throws InvalidParameterException
     */
    public function pay(array $order)
    {
        if(empty($order)){
            throw new InvalidParameterException('Order data cannot be empty');
        }

        $this->payload['method']    = $this->method();
        $load = $this->payload;

        $load['biz_content'] = json_encode($order);
        $load['method']      = $this->method();
        $load['sign'] = Support::generateSign($load);

        return $this->processingApiResult($load, HttpClient::request($this->gateway, 'POST', Support::filter($load)));
    }

    /**
     * @return string
     */
    private function method()
    {
        return 'alipay.trade.create';
    }

}