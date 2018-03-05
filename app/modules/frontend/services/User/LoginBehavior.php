<?php
/**
 * Created by PhpStorm.
 * User: panguoping
 * Date: 2018/3/4
 * Time: 上午12:08
 */

namespace XShop\Modules\Frontend\Services\User;

use XShop\Library\OpensslUtil;
use XShop\Modules\Frontend\Services\User\Exceptions\LoginException;

class LoginBehavior
{
    const CHECK_SESSION_INFO_KEY = 'xShopCheckKey';

    /**
     * 用户登录
     * @param $userId
     * @return bool
     * @throws LoginException
     */
    public function login($userId)
    {
        if(!$this->isLogin()) {
            $userInfo = Info::baseInfo($userId);
            if(empty($userInfo)) {
                throw new LoginException('用户不存在');
            }
            $this->storeSession($userInfo);
        }
        return true;
    }

    /**
     * 是否登录
     * @return bool
     */
    public function isLogin()
    {
        $loginData = $this->getLoginUserData();
        if(!isset($loginData['userId']) || $loginData['userId'] < 1) {
            return false;
        }
        $loginEnc = \Phalcon\Di::getDefault()->get('cookies')->get(self::CHECK_SESSION_INFO_KEY);
        if(empty($loginEnc)) {
            return false;
        }
        $cookieData = OpensslUtil::decrypt($loginEnc);
        if(empty($cookieData)) {
            return false;
        }
        $cookieData = explode('#', $cookieData);
        if(count($cookieData) != 2 ) {
            return false;
        }
        if($cookieData[0] != $loginData['userId'] || $cookieData[1] != $loginData['randomPwd']) {
            return false;
        }
        return true;
    }

    /**
     * 登出
     * @return bool
     */
    public function logout()
    {
        if(!$this->isLogin()) {
            return true;
        }
        //让cookie过期
        $cookie = \Phalcon\Di::getDefault()->get('cookies');
        $cookie->set(self::CHECK_SESSION_INFO_KEY, '', -1, '/');
        $cookie->send();
        //删除session
        \Phalcon\Di::getDefault()->get('session')->destroy();
        return true;
    }

    public function getLoginUserData()
    {
        $session = \Phalcon\Di::getDefault()->get('session');
        $data['userId'] = $session->get('userId');
        $data['nickname'] = $session->get('nickname');
        $data['avatar'] = $session->get('avatar');
        $data['randomPwd'] = $session->get('randomPwd');
        return $data;
    }

    /**
     * 登录用户ID
     * @return int
     */
    public function getLoginUserId()
    {
        $loginData = $this->getLoginUserData();
        return intval($loginData['userId']);
    }

    /**
     * 保存session数据
     * @param array $userInfo
     */
    private function storeSession(array $userInfo)
    {
        $randomPwd = uniqid();
        $cookieEnc = $userInfo['user_id'] . '#' . $randomPwd;
        $cookieEnc = OpensslUtil::encrypt($cookieEnc);

        $session = \Phalcon\Di::getDefault()->get('session');
        $session->set('nickname', $userInfo['nickname']);
        $session->set('userId', $userInfo['user_id']);
        $session->set('avatar', $userInfo['avatar']);
        $session->set('randomPwd', $randomPwd);

        $cookie = \Phalcon\Di::getDefault()->get('cookies');
        $cookie->set(self::CHECK_SESSION_INFO_KEY, $cookieEnc, time() + 7200, '/', false, '', true);
        $cookie->send();
    }

    /**
     * 验证登录信息
     * @param $userId
     * @throws LoginException
     */
    /*private function checkLoginCookie($userId)
    {
        $loginEnc = \Phalcon\Di::getDefault()->get('cookies')->get(self::CHECK_SESSION_INFO_KEY);
        if(empty($loginEnc)) {
            throw new LoginException('登录信息丢失');
        }
        $cookieData = OpensslUtil::decrypt($loginEnc);
        if(empty($cookieData)) {
            throw new LoginException('登录信息异常');
        }
        $cookieData = explode('#', $cookieData);
        if(count($cookieData) != 2 ) {
            throw new LoginException('登录信息异常');
        }
        if($cookieData[0] != $userId || $cookieData[1] != \Phalcon\Di::getDefault()->get('session')->get('randomPwd')) {
            throw new LoginException('其他用户已登录');
        }
    }*/
}