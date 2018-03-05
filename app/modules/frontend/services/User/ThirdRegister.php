<?php
/**
 * Created by PhpStorm.
 * User: panguoping
 * Date: 2018/3/4
 * Time: 上午12:23
 */
namespace XShop\Modules\Frontend\Services\User;

use XShop\Models\UserThirdRelation;
use XShop\Modules\Frontend\Repos\UserThirdRelationRepo;
use XShop\Modules\Frontend\Services\User\Exceptions\LoginException;

abstract class ThirdRegister
{
    /**
     * 第三方注册
     * @param array $accessTokenInfo
     * @return int
     * @throws LoginException
     */
    public function do(array $accessTokenInfo)
    {
        $userInfo = $this->userInfoViaThird($accessTokenInfo);

        $db = \Phalcon\Di::getDefault()->get('db');
        $db->begin();

        try {
            //第三方用户是否已经存在
            $userId = $this->getUserId($accessTokenInfo);
            if($userId < 1) {
                //保存第三方信息
                $thirdId = $this->saveThirdInfo($accessTokenInfo);
                if($thirdId < 1) {
                    throw new LoginException('');
                }
                //记录用户信息
                $userId = $this->saveUserInfo($userInfo);
                if($userId < 1) {
                    throw new LoginException('');
                }
                //保存对应关系
                $relationId = $this->saveRelationInfo($thirdId, $userId);
                if($relationId < 1) {
                    throw new LoginException('');
                }
            }
            $db->commit();

            return $userId;
        } catch (LoginException $e) {
            $db->rollback();
            throw $e;
        } catch (\Exception $ex) {
            $db->rollback();
            throw new LoginException('');
        }
    }

    /**
     * 注册渠道
     * @return mixed
     */
    abstract protected function getVia();

    /**
     * 获取渠道说明
     * @return mixed
     */
    abstract protected function getViaText();

    /**
     * 获取第三方id
     * @param array $accessTokenInfo
     * @return mixed
     */
    abstract protected function getThirdId(array $accessTokenInfo);

    /**
     * 保存第三方信息
     * @param array $accessTokenInfo
     * @return mixed
     */
    abstract protected function saveThirdInfo(array $accessTokenInfo);

    /**
     * 获取第三方用户信息
     * @param array $accessTokenInfo
     * @return array
     */
    abstract protected function userInfoViaThird(array $accessTokenInfo);

    /**
     * 获取用户id
     * @param array $accessTokenInfo
     * @return int
     */
    protected function getUserId(array $accessTokenInfo)
    {
        $thirdId = $this->getThirdId($accessTokenInfo);
        if($thirdId < 1) {
            return 0;
        }
        return UserThirdRelationRepo::userIdByThird($thirdId, $this->getVia());
    }

    /**
     * 保存用户和第三方的关联信息
     * @param $thirdId
     * @param $userId
     * @return bool
     */
    protected function saveRelationInfo($thirdId, $userId)
    {
        $utr = new UserThirdRelation();
        $utr->third_id = $thirdId;
        $utr->user_id = $userId;
        $utr->via = $this->getVia();
        return $utr->save();
    }

    /**
     *保存用户信息
     * @param array $userInfo
     * @return int
     */
    protected function saveUserInfo(array $userInfo)
    {
        return 0;
    }
}