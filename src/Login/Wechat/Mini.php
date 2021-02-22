<?php


namespace Waiter\Login\Wechat;

use Waiter\Exceptions\InvalidParameterException;
use Waiter\Support\HttpClient;

class Mini extends Support
{
    /**
     * @param $code
     * @param $refreshToken
     * @param $grantType
     * @return mixed|void
     */
    public function getToken($code, $refreshToken = '', $grantType = 'authorization_code')
    {
        if(!$code){
            throw new InvalidParameterException('code data cannot be empty');
        }

        $load               = $this->load;
        $load['grant_type'] = $grantType;
        $load['js_code']    = $code;
        $url = $this->gateway . 'sns/jscode2session' . '?' . http_build_query($load);
        return self::processingApiResult(json_decode(HttpClient::request($url, 'GET', []), true));
    }

}