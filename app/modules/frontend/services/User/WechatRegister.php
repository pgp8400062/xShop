<?php
/**
 * Created by PhpStorm.
 * User: panguoping
 * Date: 2018/3/4
 * Time: 上午12:23
 */
namespace XShop\Modules\Frontend\Services\User;

use XShop\Models\UserThirdRelation;
use XShop\Models\UserThirdWechat;
use XShop\Modules\Frontend\Repos\UserThirdWechatRepo;

class WechatRegister extends ThirdRegister
{
    /**
     * @return int
     */
    protected function getVia()
    {
        return UserThirdRelation::VIA_WECHAT;
    }

    /**
     * @return string
     */
    protected function getViaText()
    {
        return '微信';
    }

    /**
     * @param array $accessTokenInfo
     * @return int|mixed
     */
    protected function getThirdId(array $accessTokenInfo)
    {
        if(!empty($accessTokenInfo['unionid'])) {
            return UserThirdWechatRepo::getThirdIdByUnionId($accessTokenInfo['appid'], $accessTokenInfo['unionid']);
        } else {
            return UserThirdWechatRepo::getThirdIdByOpenid($accessTokenInfo['appid'], $accessTokenInfo['openid']);
        }
    }

    /**
     * 获取第三方用户信息
     * @param array $accessTokenInfo
     * @return array
     */
    protected function userInfoViaThird(array $accessTokenInfo)
    {
        $userInfo = [];
        if($accessTokenInfo['scope'] == 'snsapi_userinfo') {
            //@todo 从第三方获取
            $userInfo = [];
        }
        return $userInfo;
    }

    /**
     * @param array $accessTokenInfo
     * @return bool
     */
    protected function saveThirdInfo(array $accessTokenInfo)
    {
        $utw = new UserThirdWechat();
        $utw->open_id = $accessTokenInfo['openid'];
        $utw->union_id = $accessTokenInfo['unionid'];
        $utw->scope = $accessTokenInfo['scope'];
        $utw->extra = json_encode($accessTokenInfo);
        $utw->create_at = date('Y-m-d H:i:s');
        return $utw->save();
    }
}