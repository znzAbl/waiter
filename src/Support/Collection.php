<?php


namespace Waiter\Support;

use Waiter\Exceptions\InvalidConfigException;

/**
 * Class Collection
 * @package Waiter\Support
 */
class Collection
{
    /**
     * @var
     */
    private static $content;

    /**
     * deposit
     * @param string $key
     * @param $item
     */
    public static function deposit(string $key, $item)
    {
        self::$content[$key] = $item;
    }

    /**
     * get
     * @param string $key
     * @param string $file
     * @return string|array|InvalidConfigException
     */
    public static function get(string $key, string $filed)
    {
        if(!isset(self::$content[$key][$filed])){
            throw new InvalidConfigException("Missing configuration items:{$filed}");
        }
        return self::$content[$key][$filed];
    }

    /**
     * clear
     * @param string $key
     * @return bool
     */
    public static function clear(string $key) : bool
    {
        if(isset(self::$content[$key])){
            unset(self::$content[$key]);
        }
        return true;
    }

}