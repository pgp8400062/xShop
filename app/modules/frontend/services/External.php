<?php
namespace XShop\Modules\Frontend\Services;

use XShop\Modules\Frontend\Services\User\Exceptions\ServiceException;

class External
{
    //商品模块
    const MODULE_PRODUCT = 'product';

    /**
     * @param $module
     * @param $method
     * @param $params
     * @return mixed
     * @throws ServiceException
     */
    final public static function call($module, $method, $params)
    {
        $class = 'XShop\Modules\Frontend\Services\\' . ucfirst(strtolower($module)) . '\External';
        if(!class_exists($class)) {
            //return self::returnFailure('模块不存在');
            throw new ServiceException('模块不存在');
        }
        if(!method_exists($class, $method)) {
            throw new ServiceException('方法不存在');
        }
        return $class::$method($params);
    }

    protected static function returnSuccess($data = [])
    {
        return ['flag' => true, 'data' => $data];
    }

    protected static function returnFailure($msg, $data = [])
    {
        return ['flag' => false, 'msg' => $msg, 'data' => $data];
    }
}