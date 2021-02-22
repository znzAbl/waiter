<?php


namespace Waiter\Support;

class WechatFun
{

    /**
     * @param array $result
     * @return array
     * @throws \Exception
     */
    protected static function processingApiResult(array $result) : array
    {
        if(isset($result['errcode'])){
            if($result['errcode'] == 0){
                return $result;
            }
            throw new \Exception('Get Wechat API Error:'.$result['errmsg']);
        }

        if(!isset($result['return_code']) || $result['return_code'] != 'SUCCESS' || $result['result_code'] != 'SUCCESS'){
            throw new \Exception('Get Wechat API Error:'.($result['return_msg'] ?? $result['retmsg'] ?? ''));
        }
        return $result;
    }
}