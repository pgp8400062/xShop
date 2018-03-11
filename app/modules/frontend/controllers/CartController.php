<?php

namespace XShop\Modules\Frontend\Controllers;

use XShop\Modules\Frontend\Services\Order\Cart;

class CartController extends ControllerSecurity
{
    /**
     * @var \XShop\Modules\Frontend\Services\Order\Cart
     */
    private $cartService;

    public function initialize()
    {
        parent::initialize();

        $this->cartService = new Cart();
    }

    /**
     * 添加到购物车
     */
    public function addProductAction()
    {
        $productId = (int)$this->request->get('product_id');
        $skuId = (int)$this->request->get('sku_id');
        if($productId < 1) {
            $this->responseFailure('参数错误');
        }
        $userId = $this->getLoginUserId();

        $returnData = $this->cartService->addProduct($userId, $productId, $skuId, 1);
        if(!$returnData['flag']) {
            $this->responseFailure($returnData['msg']);
        }
        $this->responseSuccess('加入购物车成功');
    }

    /**
     * 从购物车删除
     */
    public function removeAction()
    {
        $itemId = (int)$this->request->get('itemId');
        if($itemId < 1) {
            $this->responseFailure('参数错误');
        }
        $userId = $this->getLoginUserId();
        $returnData = $this->cartService->remove($itemId, $userId);
        if(!$returnData['flag']) {
            $this->responseFailure($returnData['msg']);
        }
        $this->responseSuccess('从购物车删除成功');
    }

    /**
     * 编辑购物车商品数量
     */
    public function editQuantityAction()
    {
        $itemId = (int)$this->request->get('itemId');
        $quantity = (int)$this->request->get('quantity');
        if($itemId < 1 || $quantity < 1) {
            $this->responseFailure('参数错误');
        }
        $userId = $this->getLoginUserId();

        $returnData = $this->cartService->editQuantity($itemId, $userId, $quantity);
        if(!$returnData['flag']) {
            $this->responseFailure($returnData['msg']);
        }
        $this->responseSuccess('编辑购买数量成功');
    }

    /**
     * 计算选中购物车条目价格
     */
    public function calculateTotalPriceAction()
    {
        $itemIds = $this->request->get('itemIds');
        if(empty($itemIds)) {
            $this->responseFailure('参数错误');
        }
        $cartIds = explode(',', $itemIds);
        $cartIds = array_map('intval', $cartIds);
        foreach ($cartIds as $cartId) {
            if($cartId < 1) {
                $this->responseFailure('参数错误');
            }
        }
        $userId = $this->getLoginUserId();
        $returnData = $this->cartService->calculateTotalPrice($cartIds, $userId);
        if(!$returnData['flag']) {
            $this->responseFailure($returnData['msg']);
        }
        $this->responseSuccess('商品价格', ['totalPrice' => $returnData['data']['totalPrice']]);
    }
}

