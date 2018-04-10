<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/7
 * Time: 21:48
 */

namespace app\index\controller;

use app\index\model\User;
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
        // todo 数据验证
        if (User::createUser($param)) {
            $this->redirect('index/login/index');
        } else {
            $this->redirect('index/login/register');
        }
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
        $user = User::where('phone', $phone)->find();
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