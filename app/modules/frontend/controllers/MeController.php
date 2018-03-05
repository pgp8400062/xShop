<?php
namespace XShop\Modules\Frontend\Controllers;

use XShop\Models\User;
use XShop\Modules\Frontend\Services\User\Info;
use XShop\Modules\Frontend\Services\User\LoginBehavior;

/**
 * 登录用户操作
 * Class MeController
 * @package XShop\Modules\Frontend\Controllers
 */
class MeController extends ControllerSecurity
{
    /**
     * 登出
     */
    public function logoutAction()
    {
        $success = (new LoginBehavior())->logout();
        if(!$success) {
            $this->responseSuccess('登出成功');
        }
        $this->responseFailure('登出失败');
    }

    /**
     * 用户基本信息
     */
    public function baseInfoAction()
    {
        $userId = $this->getLoginUserId();
        $userInfo = Info::baseInfo($userId);
        $this->responseSuccess('用户基本信息', $userInfo);
    }

    /**
     * 编辑基本用户信息
     */
    public function editBaseInfoAction()
    {
        $nickname = $this->request->getPost('nickname', 'trim');
        $gender = strtoupper($this->request->getPost('gender', 'trim'));
        $avatar = $this->request->getPost('avatar', 'trim');
        if(empty($nickname) || empty($gender) || empty($avatar)) {
            $this->responseFailure('用户信息不完整');
        }
        if(!in_array($gender, User::GENDER_ALL, true)) {
            $this->responseFailure('性别不支持');
        }

        $userInfo['nickname'] = $nickname;
        $userInfo['gender'] = $gender;
        $userInfo['avatar'] = $avatar;
        $success = Info::editBaseInfo($userInfo);
        if(!$success) {
            $this->responseFailure('编辑用户信息失败');
        }
        $this->responseSuccess('编辑用户信息成功');
    }
}

