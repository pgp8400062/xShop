<?php
namespace XShop\Modules\Frontend\Repos;

use XShop\Models\Product;

class ProductRepo
{
    public static function getByPrimary($productId)
    {
        return Product::findFirst($productId);
    }

    public static function productSkuInfo($productId, $skuId)
    {

    }
}