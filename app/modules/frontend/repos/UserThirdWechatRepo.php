<?php
/**
 * Created by PhpStorm.
 * User: panguoping
 * Date: 2018/3/4
 * Time: 上午1:03
 */
namespace XShop\Modules\Frontend\Repos;

use XShop\Models\UserThirdWechat;

class UserThirdWechatRepo
{
    /**
     * @param $appId
     * @param $openId
     * @return int
     */
    public static function getThirdIdByOpenid($appId, $openId)
    {
        $thirdInfo = UserThirdWechat::findFirst([
            'conditions' => 'open_id = :open_id: AND app_id = :app_id:',
            'bind' => ['open_id' => $openId, 'app_id' => $appId],
            'columns' => ['third_id']
        ]);
        if(!$thirdInfo) {
            return 0;
        }
        return $thirdInfo->third_id;
    }

    /**
     * @param $appId
     * @param $unionId
     * @return int
     */
    public static function getThirdIdByUnionId($appId, $unionId)
    {
        $thirdInfo = UserThirdWechat::findFirst([
            'conditions' => 'union_id = :union_id: AND app_id = :app_id:',
            'bind' => ['union_id' => $unionId, 'app_id' => $appId],
            'columns' => ['third_id']
        ]);
        if(!$thirdInfo) {
            return 0;
        }
        return $thirdInfo->third_id;
    }
}