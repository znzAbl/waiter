<?php


namespace Waiter\Contracts;


interface LoginInterface
{
    /**
     * @param $code
     * @param $refreshToken
     * @param $grantType
     * @return mixed
     */
    public function getToken($code, $refreshToken, $grantType);

}