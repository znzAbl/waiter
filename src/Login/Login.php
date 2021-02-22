<?php


namespace Waiter\Login;

use Waiter\Contracts\LoginInterface;
use Waiter\Login\Wechat\Mini;

/**
 * Class Login
 * @method Mini Mini() 小程序登录
 * @package Waiter\Login
 */
class Login
{
    /**
     * @var string
     */
    private $provider;

    /**
     * Login constructor.
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
     * @return LoginInterface
     * @throws \Exception
     */
    private function make($method) : LoginInterface
    {
        $assembly = $gateway = preg_replace('/\\\Login/', '', __CLASS__, 1) . '\\' . $this->provider;
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
     * @return LoginInterface
     * @throws \Exception
     */
    private function makeAssembly(string $assembly) : LoginInterface
    {
        $app = new $assembly();
        if($app instanceof LoginInterface){
            return $app;
        }
        throw new \Exception("Can't find the Class you need：{$assembly}");
    }
}