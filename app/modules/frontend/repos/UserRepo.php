<?php
/**
 * Created by PhpStorm.
 * User: panguoping
 * Date: 2018/3/4
 * Time: 上午1:03
 */
namespace XShop\Modules\Frontend\Repos;

use XShop\Models\User;

class UserRepo
{
    /**
     * 用户基本信息
     * @param $userID
     * @return array
     */
    public static function baseInfo($userID)
    {
        $userInfo = User::findFirst([
            'conditions' => 'user_id = :user_id:',
            'bind' => ['user_id' => $userID],
            'columns' => ['user_id', 'gender', 'nickname', 'avatar']
        ]);
        if(!$userInfo) {
            return [];
        }
        return $userInfo->toArray();
    }
}