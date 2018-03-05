<?php
namespace XShop\Modules\Frontend\Controllers;

use XShop\Modules\Frontend\Services\User\LoginBehavior;

class ControllerSecurity extends ControllerBase
{
    /**
     * 是否登录的判断
     */
    public function initialize()
    {
        if(!(new LoginBehavior())->isLogin()) {
            $this->responseJson(-100, '请先登录');
        }
    }

    /**
     * 获取登录用户id
     * @return int
     */
    protected function getLoginUserId()
    {
        return (new LoginBehavior())->getLoginUserId();
    }
}
