<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23
 * Time: 21:31
 */

namespace app\index\controller;


use app\common\BaseController;

class Product extends BaseController
{
    public function index()
    {
        return $this->fetch('product-index');
    }

    public function edit()
    {
        return $this->fetch('product-edit');
    }

}