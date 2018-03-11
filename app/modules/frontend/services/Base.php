<?php
namespace XShop\Modules\Frontend\Services;

class Base
{
    protected function returnController($flag, $msg = '', $data = [])
    {
        return ['flag' => $flag, 'msg' => $msg, 'data' => $data];
    }

    protected function returnControllerFailure($msg)
    {
        return $this->returnController(false, $msg);
    }

    protected function returnControllerSuccess($data = [])
    {
        return $this->returnController(true, '', $data);
    }
}