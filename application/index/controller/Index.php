<?php
namespace app\index\controller;

use app\common\BaseController;

class Index extends BaseController
{
    public function index()
    {
        return $this->fetch('device-list');
    }

    public function edit()
    {
        return $this->fetch('device-edit');
    }

    public function detail()
    {
        return $this->fetch('device-detail');
    }

    public function addTrigger()
    {
        return $this->fetch('add_trigger');
    }

    public function delete()
    {
        return self::ajaxMsg();
    }

    public static function sendOrder()
    {
        $order_info = request()->get();
        $msg = "向设备ID:{$order_info['device_id']}发送命令成功";
        return self::ajaxMsg(true, $msg);
    }

    public static function addDevice()
    {
        return self::ajaxMsg(true, '设备添加成功');
    }
}
