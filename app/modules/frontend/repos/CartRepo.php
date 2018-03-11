<?php
namespace XShop\Modules\Frontend\Repos;

use XShop\Models\Cart;

class CartRepo
{
    /**
     * 主键查询
     * @param $cartId
     * @return \Phalcon\Mvc\Model\ResultInterface|Cart
     */
    public static function getByPrimary($cartId)
    {
        return Cart::findFirst($cartId);
    }

    /**
     * 用户购物车总数
     * @param $userId
     * @return int
     */
    public static function totalItems($userId)
    {
        $sql = "SELECT COUNT(DISTINCT mall_id) AS total FROM cart WHERE user_id = :user_id";
        $data = \Phalcon\Di::getDefault()->get('db')->query($sql, ['user_id' => $userId])->fetch();
        return intval($data['total']);
    }

    /**
     * 购物车按店铺分类
     * @param $userId
     * @param $page
     * @param $pageSize
     * @return \Phalcon\Mvc\Model\ResultSetInterface|Cart|Cart[]
     */
    public static function userItemGroupByMall($userId, $page, $pageSize)
    {
        $data = Cart::find([
            'conditions' => 'user_id = :user_id:',
            'bind' => ['user_id' => $userId],
            'columns' => ['DINSTINCT(mall_id) AS mall_id'],
            'order' => 'item_id desc',
            'limit' => $pageSize,
            'offset' => ($page - 1) * $pageSize
        ]);
        return $data->toArray();
    }

    /**
     * 用户购物车列表
     * @param int $userId
     * @param int $mallId
     * @return \Phalcon\Mvc\Model\ResultSetInterface|Cart|Cart[]
     */
    public static function userMallItems($userId, $mallId)
    {
        return Cart::find([
            'conditions' => 'user_id = :user_id: AND mall_id = :mall_id:',
            'bind' => ['user_id' => $userId, 'mall_id' => $mallId],
            'order' => 'item_id desc',
        ]);
    }

    /**
     * 用户购物车商品
     * @param $userId
     * @param $productId
     * @param $skuId
     * @return \Phalcon\Mvc\Model\ResultInterface|Cart
     */
    public static function userItemProduct($userId, $productId, $skuId)
    {
        return Cart::findFirst([
            'conditions' => 'user_id = :user_id: AND product_id = :product_id: And sku_id = :sku_id:',
            'bind' => ['user_id' => $userId, 'product_id' => $productId, 'sku_id' => $skuId],
        ]);
    }

    /**
     * 用户购物车详情
     * @param $cartId
     * @param $userId
     * @return \Phalcon\Mvc\Model\ResultInterface|Cart
     */
    public static function userItemInfo($cartId, $userId)
    {
        return Cart::findFirst([
            'conditions' => 'cart_id = :cart_id: AND user_id = :user_id:',
            'bind' => ['cart_id' => $cartId, 'user_id' => $userId]
        ]);
    }
}