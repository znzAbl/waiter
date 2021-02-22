<?php


namespace Waiter\Contracts;


interface PaymentInterface
{
    /**
     * pay
     * @param array $order
     * @return mixed
     */
    public function pay(array $order);

    /**
     * Query an order.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function find($order, string $type);

    /**
     * Refund an order.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @return Collection
     */
    public function refund(array $order);

    /**
     * Cancel an order.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function cancel($order);

    /**
     * Close an order.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @param string|array $order
     *
     * @return Collection
     */
    public function close($order);

    /**
     * Verify a request.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @param string|array|null $content
     *
     * @return Collection
     */
    public function verify($content, bool $refund);

    /**
     * Echo success to server.
     *
     * @author znzAbl <znz_abl@qq.com>
     *
     * @return Response
     */
    public function success();

}