<?php
/**
 * Created by PhpStorm.
 * User: panguoping
 * Date: 2018/3/4
 * Time: 上午12:14
 */

namespace XShop\Modules\Frontend\Services\User;

class WechatAuthenticator implements Authenticator
{
    //微信appid
    private $appId;
    //微信appsecret
    private $appSecret;

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    /**
     * 跳转到第三方授权
     * @return mixed|void
     */
    public function start()
    {
        // TODO: Implement start() method.
    }

    /**
     * 通过code去授权
     * @param $code
     * @return mixed|void
     */
    public function infoByCredentials($code)
    {
        // TODO: Implement infoByCredentials() method.
    }
}