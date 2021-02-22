<?php


namespace Waiter\Login\Alipay;

use Waiter\Support\HttpClient;
use Waiter\Exceptions\InvalidParameterException;

class Mini extends Support
{

    /**
     * @param $code
     * @param $refreshToken
     * @param string $grantType
     * @return mixed|void
     */
    public function getToken($code, $refreshToken = '', $grantType = 'authorization_code')
    {
        if(!$code){
            throw new InvalidParameterException('code data cannot be empty');
        }
        $this->load['method']    = $this->method();
        $load                    = $this->load;
        $load['grant_type']      = $grantType;
        $load['code']            = $code;
        if($refreshToken != ''){
            $load['refresh_token'] = $refreshToken;
        }
        $load['sign'] = Support::generateSign($load);
        return $this->processingApiResult($load, HttpClient::request($this->gateway, 'POST', Support::filter($load)));
    }
    /**
     * @return string
     */
    private function method()
    {
        return 'alipay.system.oauth.token';
    }
}