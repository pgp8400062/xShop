<?php
namespace XShop\Modules\Frontend\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    /**
     * 返回json数据
     * @param int $flag
     * @param string $msg
     * @param array $data
     * @param array $extra
     */
    protected function responseJson($flag, $msg, array $data = [], array $extra = [])
    {
        if(empty($data)) {
            $data = new \stdClass();
        }
        if(empty($extra)) {
            $extra = new \stdClass();
        }
        $response = ['flag' => $flag, 'msg' => $msg, 'data' => $data, 'extra' => $extra];
        echo $response;exit;
    }

    /**
     * 返回成功
     * @param $msg
     * @param array $data
     * @param array $extra
     */
    protected function responseSuccess($msg, array $data = [], array $extra = [])
    {
        $this->responseJson(0, $msg, $data, $extra);
    }

    /**
     * 返回失败
     * @param $msg
     * @param array $data
     * @param array $extra
     */
    protected function responseFailure($msg, array $data = [], array $extra = [])
    {
        $this->responseJson(-1, $msg, $data, $extra);
    }
}
