<?php


namespace Waiter\Payment\Alipay;

use Waiter\Contracts\PaymentInterface;
use Waiter\Support\AlipayFun;
use Waiter\Support\Collection;

/**
 * Class Support
 * @package Waiter\Payment\Alipay
 */
class Support extends AlipayFun implements PaymentInterface
{
    /**
     * 普通模式.
     */
    const MODE_NORMAL = 'normal';

    /**
     * Const url.
     */
    const URL = [
        self::MODE_NORMAL => 'https://openapi.alipay.com/gateway.do?charset=utf-8',
    ];

    /**
     * Alipay payload.
     *
     * @var array
     */
    protected $payload;

    /**
     * Alipay gateway.
     *
     * @var string
     */
    protected $gateway;

    /**
     * Alipay mode.
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
            'app_id' => Collection::get('config', 'app_id'),
            'format' => 'JSON',
            'charset' => 'utf-8',
            'sign_type' => 'RSA2',
            'version' => '1.0',
            'notify_url' => Collection::get('config', 'notify_url'),
            'timestamp' => date('Y-m-d H:i:s'),
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
     * @param array|string|null $content
     * @param bool $refund
     * @return bool
     * @throws \Waiter\Exceptions\InvalidConfigException
     */
    public function verify($content, bool $refund = false) : bool
    {
        if (isset($content['fund_bill_list'])) {
            $content['fund_bill_list'] = htmlspecialchars_decode($content['fund_bill_list']);
        }

        if (self::verifySign($content)) {
            return true;
        }
        return false;
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

}