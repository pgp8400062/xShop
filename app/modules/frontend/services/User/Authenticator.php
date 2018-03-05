<?php
/**
 * Created by PhpStorm.
 * User: panguoping
 * Date: 2018/3/4
 * Time: 上午12:08
 */

namespace XShop\Modules\Frontend\Services\User;

interface Authenticator
{
    /**
     * 跳转到第三方授权
     * @return mixed
     */
    public function start();

    /**
     * 通过code去授权
     * @param $code
     * @return mixed
     */
    public function infoByCredentials($code);
}