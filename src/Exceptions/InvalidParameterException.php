<?php


namespace Waiter\Exceptions;


class InvalidParameterException extends Exception
{
    /**
     * Bootstrap.
     *
     * @param string       $message
     * @param array|string $raw
     */
    public function __construct($message, $raw = [])
    {
        parent::__construct('INVALID_PARAMETER: '.$message, $raw, self::INVALID_PARAMETER);
    }
}