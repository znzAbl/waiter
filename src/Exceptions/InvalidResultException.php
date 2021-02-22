<?php


namespace Waiter\Exceptions;


class InvalidResultException extends Exception
{
    /**
     * Bootstrap.
     *
     * @param string       $message
     * @param array|string $raw
     */
    public function __construct($message, $raw = [])
    {
        parent::__construct('INVALID_RESULT: '.$message, $raw, self::INVALID_RESULT);
    }
}