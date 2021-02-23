<?php


namespace Waiter\Payment\Wechat;

use Symfony\Component\HttpFoundation\Request;
use Waiter\Contracts\PaymentInterface;
use Waiter\Support\Collection;
use Waiter\Support\Str;
use Waiter\Support\HttpClient;
use Waiter\Support\WechatFun;

/**
 * Class Support
 * @package Waiter\Payment\Wechat
 */
class Support extends WechatFun implements PaymentInterface
{
    /**
     * 普通模式.
     */
    const MODE_NORMAL = 'normal';

    /**
     * Const url.
     */
    const URL = [
        self::MODE_NORMAL => 'https://api.mch.weixin.qq.com/',
    ];

    /**
     * Wechat payload.
     *
     * @var array
     */
    protected $payload;

    /**
     * Wechat gateway.
     *
     * @var string
     */
    protected $gateway;

    /**
     * Wechat mode.
     * @var string
     */
    protected $mode;

    /**
     * Support constructor.
     * @throws \Waiter\Exceptions\InvalidConfigException
     */
    public function __construct()
    {
        $this->mode = Collection::get('config', 'mode');

        $this->gateway = self::URL[$this->mode];

        $this->payload = [
            'appid' => Collection::get('config', 'app_id'),
            'mch_id' => Collection::get('config', 'mch_id'),
            'nonce_str' => Str::random(),
            'fee_type' => 'CNY',
            'sign_type' => 'MD5',
            'limit_pay' => 'no_credit',
            'notify_url' => Collection::get('config', 'notify_url'),
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'],
        ];
    }

    /**
     * @param array $order
     * @return mixed|void
     */
    public function pay(array $order)
    {

    }
    /**
     * Query an order.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function find($order, string $type)
    {

    }

    /**
     * Refund an order.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @return Collection
     */
    public function refund(array $order)
    {

    }

    /**
     * Cancel an order.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function cancel($order)
    {

    }

    /**
     * Close an order.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function close($order)
    {

    }

    /**
     * Verify a request.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @param string|array|null $content
     *
     * @return Collection
     */
    public function verify($content, bool $refund)
    {

    }

    /**
     * Echo success to server.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @return Response
     */
    public function success()
    {

    }

    /**
     *
     */
    protected function preOrder(array $load)
    {
        $load['sign'] = self::generateSign($load);

        return self::processingApiResult(Str::fromXml(HttpClient::request($this->gateway . 'pay/unifiedorder', 'POST', Str::toXml($load))));
    }

    /**
     * generateSign
     * @param $data
     * @return string
     */
    protected static function generateSign($data): string
    {
        $key = Collection::get('config', 'pay_key');

        ksort($data);

        $string = md5(self::getSignContent($data).'&key='.$key);

        return strtoupper($string);
    }

    /**
     * getSignContent
     * @param $data
     * @return string
     */
    private static function getSignContent($data): string
    {
        $buff = '';

        foreach ($data as $k => $v) {
            $buff .= ('sign' != $k && '' != $v && !is_array($v)) ? $k.'='.$v.'&' : '';
        }

        return trim($buff, '&');
    }

}