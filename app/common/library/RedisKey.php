<?php
namespace XShop\Library;

class RedisKey
{
    /**
     * 当天的订单数量
     * @return string
     */
    public static function todayOrderNumKey()
    {
        return 'XSHOP:ORDER:TODAY_ORDER_NUM:' . date('Ymd');
    }
}