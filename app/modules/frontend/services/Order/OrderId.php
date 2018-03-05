<?php
namespace XShop\Modules\Frontend\Services\Order;

use XShop\Library\RedisKey;

/**
 * 生成订单id
 * Class OrderId
 * @package XShop\Modules\Frontend\Services\Order
 */
class OrderId
{
    public static function generate()
    {
        $date = date('Ymd');

        $orderNums = \Phalcon\Di::getDefault()->get('redis')->incr(RedisKey::todayOrderNumKey());
        if(strlen($orderNums) < 8) {
            $orderNums = str_repeat('0', 8 - strlen($orderNums)) . $orderNums;
        }

        return $date . $orderNums . '00000';
    }
}