<?php
namespace XShop\Modules\Frontend\Repos;

use XShop\Models\ProductSku;

class ProductSkuRepo
{
    public static function getByPrimary($skuId)
    {
        return ProductSku::findFirst($skuId);
    }

    /**
     * @param $productId
     * @param $skuId
     * @return \Phalcon\Mvc\Model\ResultInterface|ProductSku
     */
    public static function productSkuInfo($productId, $skuId)
    {
        return ProductSku::findFirst([
            'conditions' => 'sku_id = :sku_id: AND product_id = :product_id:',
            'bind' => ['sku_id' => $skuId, 'product_id' => $productId]
        ]);
    }

    /**
     * @param $productId
     * @return \Phalcon\Mvc\Model\ResultSetInterface|ProductSku|ProductSku[]
     */
    public static function skus($productId)
    {
        return ProductSku::find([
            'conditions' => 'product_id = :product_id:',
            'bind' => ['product_id' => $productId]
        ]);
    }

    /**
     * 商品是否有sku
     * @param $productId
     * @return bool
     */
    public static function hasSku($productId)
    {
        if(count(self::skus($productId)) < 1) {
            return false;
        }
        return true;
    }
}