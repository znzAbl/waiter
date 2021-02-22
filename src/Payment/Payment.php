<?php


namespace Waiter\Payment;

use Waiter\Contracts\PaymentInterface;
use Waiter\Payment\Wechat\Mini;
use Waiter\Payment\Wechat\Support;

/**
 * Class Payment
 * @method Mini Mini() 小程序支付
 * @method Support Support() 其他方法
 * @package Waiter\Payment
 */
class Payment
{
    /**
     * @var string
     */
    private $provider;

    /**
     * Payment constructor.
     * @param string $provider
     */
    public function __construct(string $provider)
    {
       $this->provider = $provider;
    }

    /**
     * @param $method
     * @param $params
     * @return PaymentInterface
     * @throws \Exception
     */
    public function __call($method, $params)
    {
        return $this->make($method);
    }

    /**
     * @param $method
     * @return PaymentInterface
     * @throws \Exception
     */
    private function make($method) : PaymentInterface
    {
        $assembly = $gateway = preg_replace('/\\\Payment/', '', __CLASS__, 1) . '\\' . $this->provider;
        $assembly .= '\\' . $method;
        if(class_exists($assembly) && $app = $this->makeAssembly($assembly)){
            return $app;
        }
        $gateway .= '\\' . 'Support';
        if(class_exists($gateway) && $app = $this->makeAssembly($gateway)){
            return $app;
        }
        throw new \Exception("Can't find the Class you need：{$assembly}");
    }

    /**
     * @param string $assembly
     * @return PaymentInterface
     * @throws \Exception
     */
    private function makeAssembly(string $assembly) : PaymentInterface
    {
        $app = new $assembly();
        if($app instanceof PaymentInterface){
            return $app;
        }
        throw new \Exception("Can't find the Class you need：{$assembly}");
    }

}