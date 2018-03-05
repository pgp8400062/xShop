<?php
/**
 * Created by PhpStorm.
 * User: panguoping
 * Date: 2018/3/4
 * Time: 上午12:08
 */

namespace XShop\Modules\Frontend\Services\User;

use XShop\Models\User;
use XShop\Modules\Frontend\Repos\UserRepo;

class Info
{
    /**
     * 基本信息
     * @param $userId
     * @return array
     */
    public static function baseInfo($userId)
    {
        return UserRepo::baseInfo($userId);
    }

    /**
     * 编辑用户信息
     * @param array $userInfo
     * @return bool
     */
    public static function editBaseInfo(array $userInfo)
    {
        $user = new User();
        $user->nickname = $userInfo['nickname'];
        $user->avatar = $userInfo['avatar'];
        $user->gender = $userInfo['gender'];
        return $user->save();
    }
}