<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/7
 * Time: 21:48
 */

namespace app\index\controller;


use app\common\BaseController;
use function request;

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

    private function checkPassword($phone, $password)
    {
//        return []

    }


}