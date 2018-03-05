<?php
/**
 * Created by PhpStorm.
 * User: panguoping
 * Date: 2018/3/4
 * Time: 上午1:03
 */
namespace XShop\Modules\Frontend\Repos;

use XShop\Models\UserThirdRelation;
use XShop\Models\UserThirdWechat;

class UserThirdRelationRepo
{
    /**
     * @param $thirdId
     * @param $via
     * @return int
     */
    public static function userIdByThird($thirdId, $via)
    {
        $relation = UserThirdRelation::findFirst([
            'conditions' => 'third_id = :third_id: AND via = :via:',
            'bind' => ['third_id' => $thirdId, 'via' => $via]
        ]);
        if(!$relation) {
            return 0;
        }
        return $relation->user_id;
    }
}