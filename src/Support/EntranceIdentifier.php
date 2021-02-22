<?php


namespace Waiter\Support;

/**
 * Class EntranceIdentifier
 * @package Waiter\Support
 */
class EntranceIdentifier
{
    /**
     * provider
     * @var string
     */
    private $provider;

    /**
     * obj
     * @var self
     */
    private static $obj;

    /**
     * EntranceIdentifier constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->provider = static::getAssembly();

        Collection::deposit('config', $config);
    }

    /**
     * @param $method
     * @param $params
     * @return mixed
     */
    public function __call($method, $params)
    {
        return $this->make($method);
    }

    /**
     * @param string $method
     * @return mixed
     */
    private function make(string $method)
    {
        $gateway = str_replace('Support\\' . $this->provider, $method, get_class($this)) . '\\' . $method;
        if (class_exists($gateway)) {
            return $this->makeAssembly($gateway);
        }
    }

    /**
     * @param string $gateway
     * @return mixed
     */
    private function makeAssembly(string $gateway)
    {
        return new $gateway($this->provider);
    }


}