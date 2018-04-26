<?php
/**
 * 项目: net
 * 作者: Jason
 * 日期: 2018/4/24
 * 时间: 21:21
 */

namespace app\index\controller;


use app\common\BaseController;

class Trigger extends BaseController
{
    public function index()
    {
        return $this->fetch('trigger-list');
    }


}