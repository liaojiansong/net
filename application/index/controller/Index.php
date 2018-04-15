<?php

namespace app\index\controller;

use app\common\BaseController;
use app\index\model\DevicesModel;

class Index extends BaseController
{
    public function index()
    {
        $devices_list = DevicesModel::paginate(5);
        $this->assign([
            'devices_list' => $devices_list,
        ]);
        return $this->fetch('device-list');
    }

    public function edit()
    {
        $id = $this->request->param('id');
        $one = DevicesModel::get($id)->hidden(['create_time', 'update_time'])->toJson();
        $this->assign('one', $one);
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
        $id = $this->request->param('id');
        DevicesModel::destroy($id);
        return self::ajaxMsg();
    }

    public static function sendOrder()
    {
        $order_info = request()->get();
        $msg = "向设备ID:{$order_info['device_id']}发送命令成功";
        return self::ajaxMsg(true, $msg);
    }

    public function addDevice()
    {
        $param = $this->request->param();
        $flag = $this->validate($param, 'CommonValidate.add_device');
        // 验证成功
        if ($flag === true) {
            $res = DevicesModel::newCreate($param);
            if ($res) {
                $is_success = true;
                $msg = "设备添加成功,ID为:" . $res;
            } else {
                $is_success = false;
                $msg = '添加失败';
            }
            // 验证失败
        } else {
            $is_success = false;
            $msg = $flag;
        }
        return self::ajaxMsg($is_success, $msg);
    }
}
