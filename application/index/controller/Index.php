<?php

namespace app\index\controller;

use app\common\BaseController;
use app\index\model\DevicesModel;


class Index extends BaseController
{
    /**
     * 设备列表主页
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $devices_list = DevicesModel::paginate(5);
        $this->assign([
            'devices_list' => $devices_list,
        ]);
        return $this->fetch('device-list');
    }

    /**
     * 设备编辑页面
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function edit()
    {
        $id = $this->request->param('id');
        $one = DevicesModel::get($id)->hidden(['create_time', 'update_time'])->toJson();
        $this->assign('one', $one);
        return $this->fetch('device-edit');
    }

    public function update()
    {
        $param = request()->param();
        $flag = $this->validate($param, 'CommonValidate.add_device');
        if ($flag === true) {
            $device = new DevicesModel();
            $device->newUpdate($param['id'], $param);
            return self::ajaxMsg(true, '编辑成功');
        } else {
            return self::ajaxMsg(false, $flag);
        }
    }

    /**
     * 设备详情
     * @return mixed
     */
    public function detail()
    {
        $id = $this->request->param('id');
        $one = DevicesModel::get($id)->hidden(['create_time', 'update_time']);
        $this->assign('one', $one);
        return $this->fetch('device-detail');
    }

    /**
     * 添加触发器
     * @return mixed
     */
    public function addTrigger()
    {
        return $this->fetch('add_trigger');
    }

    /**
     * 删除设备(ajax)
     * @return array
     */
    public function delete()
    {
        $id = $this->request->param('id');
        DevicesModel::destroy($id);
        return self::ajaxMsg();
    }

    /**
     * 发送命令
     * @return array
     */
    public static function sendOrder()
    {
        $order_info = request()->param();
        $msg = "向设备ID:{$order_info['device_id']}发送命令成功";
        return self::ajaxMsg(true, $msg);
    }

    /**
     * 添加设备(ajax)
     * @return array
     */
    public function addDevice()
    {
        $flag = $this->validate($this->request->param(), 'CommonValidate.add_device');
        // 验证成功
        if ($flag === true) {
            $res = DevicesModel::newCreate($this->request->param());
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

    public function liveData()
    {
        // 获取当前时间，PHP 时间戳是秒为单位的，JS 中则是毫秒，所以这里乘以 1000
        $x = time() * 1000;
        // y 值为随机值
        $y = rand(0, 100);

        // 创建 PHP 数组，并最终用 json_encode 转换成 JSON 字符串
        $ret = array($x, $y);
        echo json_encode($ret);
    }
}
