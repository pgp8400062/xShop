<?php
namespace XShop\Modules\Frontend\Services\Order;

use XShop\Modules\Frontend\Repos\CartRepo;
use XShop\Modules\Frontend\Services\Base;
use XShop\Modules\Frontend\Services\External;
use XShop\Modules\Frontend\Services\User\Exceptions\CartException;
use XShop\Modules\Frontend\Services\User\Exceptions\ServiceException;

class Cart extends Base
{
    /**
     * 购物车列表
     * @param $userId
     * @param $page
     * @param $pageSize
     * @return array
     */
    public function items($userId, $page, $pageSize)
    {
        $total = CartRepo::totalItems($userId);

        $items = [];
        if($total > ($page - 1) * $pageSize) {
            $mallIds = CartRepo::userItemGroupByMall($userId, $page, $pageSize);
            foreach ($mallIds as $mallId) {
                $mallItems = CartRepo::userMallItems($userId, $mallId);
                $items[$mallId] = $mallItems->toArray();
            }
        }
        $data = ['total' => $total, 'data' => $items];
        return $this->returnControllerSuccess($data);
    }

    /**
     * 购物车添加商品
     * @param $userId
     * @param $productId
     * @param $skuId
     * @param $quantity
     * @return array
     */
    public function addProduct($userId, $productId, $skuId, $quantity)
    {
        try {
            $this->checkProductSku($productId, $skuId);

            $cartInfo = CartRepo::userItemProduct($userId, $productId, $skuId);
            if (false === $cartInfo) {
                $cartNum = CartRepo::totalItems($userId);
                if ($cartNum > 50) {
                    throw new CartException('购物车最多只能添加50个商品');
                }
                $cartInfo = new \XShop\Models\Cart();
                $cartInfo->user_id = $userId;
                $cartInfo->product_id = $productId;
                $cartInfo->mall_id = 0;
                $cartInfo->sku_id = $skuId;
                $cartInfo->quantity = $quantity;
                $cartInfo->create_time = date('Y-m-d H:i:s');
                if (!$cartInfo->save()) {
                    throw new CartException('添加购物车失败');
                }
            } else {
                $cartInfo->quantity = $quantity;
                if (!$cartInfo->save()) {
                    throw new CartException('添加购物车失败');
                }
            }
            return $this->returnControllerSuccess(['itemId' => $cartInfo->item_id]);
        } catch (CartException $e) {
            return $this->returnControllerFailure($e->getMessage());
        }
    }

    /**
     * 从购物车移除
     * @param $itemId
     * @param $userId
     * @return array
     */
    public function remove($itemId, $userId)
    {
        try {
            $cartInfo = CartRepo::userItemInfo($itemId, $userId);
            if (false === $cartInfo) {
                throw new CartException('购物车不存在');
            }
            if (!$cartInfo->delete()) {
                throw new CartException('购物车移除失败');
            }
            return $this->returnControllerSuccess();
        } catch (CartException $e) {
            return $this->returnControllerFailure($e->getMessage());
        }
    }

    /**
     * 编辑购买数量
     * @param $itemId
     * @param $userId
     * @param $quantity
     * @return array
     */
    public function editQuantity($itemId, $userId, $quantity)
    {
        try {
            $cartInfo = CartRepo::userItemInfo($itemId, $userId);
            if (false === $cartInfo) {
                throw new CartException('购物车不存在');
            }
            $cartInfo->quantity = $quantity;
            if (!$cartInfo->save()) {
                throw new CartException('改变购买数量失败');
            }
            return $this->returnControllerSuccess();
        } catch (CartException $e) {
            return $this->returnControllerFailure($e->getMessage());
        }
    }

    /**
     * 计算商品价格
     * @param array $cartIds
     * @param $userId
     * @return array
     */
    public function calculateTotalPrice(array $cartIds, $userId)
    {
        try {
            $totalPrice = 0;
            foreach ($cartIds as $cartId) {
                $cartInfo = CartRepo::userItemInfo($cartId, $userId);
                if (false === $cartInfo) {
                    throw new CartException('购物车不存在');
                }
                //检查商品
                $this->checkProductSku($cartInfo->product_id, $cartInfo->sku_id);
                //商品价格
                $productPrice = $this->productPrice($cartInfo->product_id, $cartInfo->sku_id);

                $totalPrice += $productPrice;
            }
            return $this->returnControllerSuccess(['totalPrice' => $totalPrice]);
        } catch (CartException $e) {
            return $this->returnControllerFailure($e->getMessage());
        }
    }

    /**
     * 商品sku信息检测
     * @param $productId
     * @param $skuId
     * @throws CartException
     */
    private function checkProductSku($productId, $skuId)
    {
        try {
            $params = ['productId' => $productId, 'skuId' => $skuId];
            $returnData = External::call(External::MODULE_PRODUCT, 'checkProductSkuInfo', $params);
            if (!$returnData['flag']) {
                throw new CartException($returnData['msg']);
            }
        } catch (ServiceException $e) {
            throw new CartException($e->getMessage());
        }
    }

    /**
     * 获取商品价格
     * @param $productId
     * @param $skuId
     * @return mixed
     * @throws CartException
     */
    private function productPrice($productId, $skuId)
    {
        try {
            $params = ['productId' => $productId, 'skuId' => $skuId];
            $returnData = External::call(External::MODULE_PRODUCT, 'productPrice', $params);
            if (!$returnData['flag']) {
                throw new CartException($returnData['msg']);
            }
            return $returnData['data']['price'];
        } catch (ServiceException $e) {
            throw new CartException($e->getMessage());
        }
    }
}