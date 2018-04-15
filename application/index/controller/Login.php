<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/4/7
 * Time: 21:48
 */

namespace app\index\controller;

use app\index\model\UserModel;
use think\Controller;
use think\Session;


class Login extends Controller
{
    public function index()
    {
        return $this->fetch('login');
    }

    public function register()
    {
        return $this->fetch('register');
    }

    public function createUser()
    {
        $param = $this->request->param();
        $flag = $this->validate($param, 'CommonValidate.add_user');
        // 验证成功
        if ($flag === true) {
            $res = UserModel::newCreate($param);
            if ($res) {
                $is_success = true;
                $msg = "注册成功,正在跳转登录界面";
                $url = url('index/login/index');
            } else {
                $is_success = false;
                $msg = '注册失败';
            }
            // 验证失败
        } else {
            $is_success = false;
            $msg = $flag;
        }
        return [
            'flag' => $is_success,
            'msg' => $msg,
            'url' => $url ?? null
        ];
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
            $this->redirect('login/index');
        }

    }

    public function checkPassword($phone, $password)
    {
        $user = UserModel::where('phone', $phone)->find();
        if ($user) {
            if ($user['phone'] == $phone && $user['password'] == $password) {
                // TODO 拉取权限,session
                $user_info = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                ];
                Session::set('user_info', $user_info);
                return [
                    'flag' => true,
                    'msg' => '登入成功',
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


    public function loginOut()
    {
        Session::delete('user_info');
        $this->redirect('login/index');
    }


}