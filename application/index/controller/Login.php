<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/7
 * Time: 21:48
 */

namespace app\index\controller;


use app\common\BaseController;
use app\index\model\User;


class Login extends BaseController
{
    public function index()
    {
        return $this->fetch('login');
    }

    // 前端ajax验证登录
    public function checkAuth()
    {

        $phone = request()->param('phone');
        $password = request()->param('password');
        $res = $this->checkPassword($phone, $password);
        if ($res['flag'] === true) {
            $this->redirect('index/index');
        } else {

        }

    }

    public function checkPassword($phone = '', $password = '')
    {
        $user = User::where('phone', '18577387793')->find();
        if ($user) {
            if ($user['phone'] == $phone && $user['password'] == md5($password)) {
                // TODO 拉取权限,session
                return [
                    'flag' => false,
                    'msg' => '密码错误',
                ];
            } else {
                return [
                    'flag' => false,
                    'msg' => '密码错误',
                ];
            }
        } else {
            return [
                'flag' => false,
                'msg' => '用户不存在',
            ];
        }
    }


}