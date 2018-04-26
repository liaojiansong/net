<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/23
 * Time: 21:31
 */

namespace app\index\controller;


use app\common\BaseController;
use app\index\model\ProductModel;
use function dump;

class Product extends BaseController
{
    public function index()
    {
        $this->assign([
            'flag' => $this->request->param('flag') ?? null,
        ]);
        return $this->fetch('product-index');
    }

    public function create()
    {
        $this->assign([
            'action' => $this->request->action(),
        ]);
        return $this->fetch('product-edit');
    }

    public function store()
    {
        $flag = $this->validate($this->request->param(), 'CommonValidate.add_product');
        // 验证成功
        if ($flag === true) {
            $res = ProductModel::newCreate($this->request->param());
            if ($res) {
                $this->redirect('index',['flag'  => 'create_success']);
            } else {
                $this->error('添加产品失败');
            }
            // 验证失败
        } else {
            $this->error($flag);
        }
    }

    public function edit()
    {
        $product_id = $this->request->param('product_id');
        $one = ProductModel::get($product_id)->hidden(['create_time', 'update_time']);
        $this->assign([
            'one'     => $one,
            'action'  => $this->request->action(),
        ]);
        return $this->fetch('product-edit');
    }

    public function update()
    {
        dump($this->request->param());
    }



}