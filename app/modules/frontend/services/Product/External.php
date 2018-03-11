<?php
namespace XShop\Modules\Frontend\Services\Product;

use XShop\Modules\Frontend\Repos\ProductRepo;
use XShop\Modules\Frontend\Repos\ProductSkuRepo;

class External extends \XShop\Modules\Frontend\Services\External
{
    /**
     * 检测商品sku信息
     * @param $params
     * @return array
     */
    public static function checkProductSkuInfo($params)
    {
        if(!isset($params['productId']) || $params['productId'] < 1) {
            return self::returnFailure('调用商品模块是发生错误 [商品id错误]');
        }
        if(!isset($params['skuId'])) {
            return self::returnFailure('调用商品模块是发生错误 [skuId错误]');
        }

        $productInfo = ProductRepo::getByPrimary($params['productId']);
        if(false === $productInfo || !$productInfo->isValid()) {
            self::returnFailure('商品不可用');
        }

        if ($params['skuId'] < 1) {
            $hasSku = ProductSkuRepo::hasSku($params['productId']);
            if($hasSku) {
                return self::returnFailure('商品sku信息不匹配');
            }
        } else {
            $skuInfo = ProductSkuRepo::productSkuInfo($params['productId'], $params['skuId']);
            if(false === $skuInfo) {
                return self::returnFailure('商品sku信息不匹配');
            }
        }
    }

    /**
     * 商品价格
     * @param $params
     * @return array
     */
    public static function productPrice($params)
    {
        if(!isset($params['productId']) || $params['productId'] < 1) {
            return self::returnFailure('调用商品模块是发生错误 [商品id错误]');
        }
        if(!isset($params['skuId'])) {
            return self::returnFailure('调用商品模块是发生错误 [skuId错误]');
        }

        $productInfo = ProductRepo::getByPrimary($params['productId']);
        if(false === $productInfo || !$productInfo->isValid()) {
            self::returnFailure('商品不可用');
        }

        $price = $productInfo->sale_price;
        if($params['skuId'] > 0) {
            $productSkuInfo = ProductSkuRepo::productSkuInfo($params['productId'], $params['skuId']);
            if(false === $productSkuInfo || !$productSkuInfo->isValid()) {
                self::returnFailure('商品sku不可用');
            }
            $price = $productSkuInfo->sale_price;
        }
        self::returnSuccess(['price' => $price]);
    }

    /**
     * 减库存
     * @param $params
     * @return array
     */
    public static function reduceProductStock($params)
    {
        return self::changeProductStock($params, 'REDUCE');
    }

    /**
     * 增加库存
     * @param $params
     * @return array
     */
    public static function increaseProductStock($params)
    {
        return self::changeProductStock($params, 'INCREASE');
    }

    /**
     * @param $params
     * @param string $flag
     * @return array
     */
    private static function changeProductStock($params, $flag = 'INCREASE')
    {
        if(!isset($params['productId']) || $params['productId'] < 1) {
            return self::returnFailure('调用商品模块是发生错误 [商品id错误]');
        }
        if(!isset($params['skuId'])) {
            return self::returnFailure('调用商品模块是发生错误 [skuId错误]');
        }
        if(!isset($params['quantity']) || $params['quantity'] < 1) {
            return self::returnFailure('调用商品模块是发生错误 [商品数量错误]');
        }

        $productInfo = ProductRepo::getByPrimary($params['productId']);
        if(false === $productInfo) {
            self::returnFailure('商品不存在');
        }

        if($flag == 'INCREASE') {
            $productInfo->stock -= $params['quantity'];
        } else {
            $productInfo->stock += $params['quantity'];
        }

        if(!$productInfo->save()) {
            self::returnFailure('减商品库存失败');
        }
        if($params['skuId'] > 0) {
            $productSkuInfo = ProductSkuRepo::productSkuInfo($params['productId'], $params['skuId']);
            if(false === $productSkuInfo) {
                self::returnFailure('商品sku不存在');
            }
            if($flag == 'INCREASE') {
                $productSkuInfo->stock -= $params['quantity'];
            } else {
                $productSkuInfo->stock += $params['quantity'];
            }
            if(!$productSkuInfo->save()) {
                self::returnFailure('减商品sku库存失败');
            }
        }
        self::returnSuccess();
    }
}