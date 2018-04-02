<?php
namespace app\index\controller;

use think\Controller;
use think\Request;

class Index extends Controller
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
        return '删除成功';
    }
}
