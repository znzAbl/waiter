<?php

namespace Waiter\Exceptions;

class Exception extends \Exception
{
    const UNKNOWN_ERROR = 9999;

    /**
     * parameter error
     */
    const INVALID_PARAMETER = 1;

    /**
     * config error
     */
    const INVALID_CONFIG = 2;
    /**
     * result error
     */
    const INVALID_RESULT = 3;

    /**
     * Raw error info.
     *
     * @var array
     */
    public $raw;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @param string       $message
     * @param array|string $raw
     * @param int|string   $code
     */
    public function __construct($message = '', $raw = [], $code = self::UNKNOWN_ERROR)
    {
        $message = '' === $message ? 'Unknown Error' : $message;
        $this->raw = is_array($raw) ? $raw : [$raw];

        parent::__construct($message, intval($code));
    }
}
