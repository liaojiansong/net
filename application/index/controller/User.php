<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/4/10
 * Time: 22:17
 */

namespace app\index\controller;


use app\common\BaseController;

class User extends BaseController
{
    public function index()
    {
        return $this->fetch('index');
    }

}