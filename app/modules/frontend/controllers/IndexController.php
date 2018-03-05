<?php

namespace XShop\Modules\Frontend\Controllers;

use Phalcon\Http\Cookie;
use XShop\Modules\Frontend\Services\User\LoginBehavior;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $isLogin = (new LoginBehavior())->isLogin();
        var_dump($isLogin);exit;
    }

}

