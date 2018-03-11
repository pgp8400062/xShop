<?php
namespace XShop\Modules\Frontend\Services\Order;

use XShop\Modules\Frontend\Services\User\Exceptions\OrderException;

class Order
{
    /**
     * 创建订单
     * @param array $products
     * @throws OrderException
     */
    public function create(array $products)
    {
        throw new OrderException('该状态订单不支持创建');
    }

    /**
     * 支付
     * @throws OrderException
     */
    public function pay()
    {
        throw new OrderException('该状态订单不支持支付');
    }

    /**
     * 退款
     * @throws OrderException
     */
    public function refund()
    {
        throw new OrderException('该状态订单不支持退款');
    }

    /**
     * 评价
     * @throws OrderException
     */
    public function evaluate()
    {
        throw new OrderException('该状态订单不支持评价');
    }

    /**
     * 关闭
     * @throws OrderException
     */
    public function close()
    {
        throw new OrderException('该状态订单不支持关闭');
    }

    /**
     * 取消订单
     * @throws OrderException
     */
    public function cancel()
    {
        throw new OrderException('该状态订单不支持取消');
    }

    /**
     * 发货
     */
    public function ship()
    {

    }
}