<?php
/**
 *
 * @User: Jason
 * @Date: 2018/4/27
 */

namespace app\index\controller;


use app\common\BaseController;
use app\index\model\DataTemplateModel;

class DataTemplate extends BaseController
{
    public function index()
    {
        // TODO 分页有问题
        $list = DataTemplateModel::paginate(100);
        $this->assign([
            'flag' => $this->request->param('flag') ?? null,
            'list' => $list,
        ]);
        return $this->fetch('data-template-list');
    }

    public function create()
    {
        $flag = $this->validate($this->request->param(), 'CommonValidate.add_template');
        // 验证成功
        if ($flag === true) {
            $res = DataTemplateModel::newCreate($this->request->param());
            if ($res) {
                $is_success = true;
                $msg = "添加模板成功";
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

    /**
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function edit()
    {
        $id = $this->request->param('id');
        $one = DataTemplateModel::get($id)->hidden(['create_time', 'update_time'])->toJson();
        $this->assign([
            'one' => $one,
            'action' => $this->request->action(),
        ]);
        return $this->fetch('data-template-edit');
    }

    public function update()
    {
        $param = request()->param();
        $flag = $this->validate($param, 'CommonValidate.add_template');
        if ($flag === true) {
            $device = new DataTemplateModel();
            $device->newUpdate($param['id'], $param);
            $this->redirect('index', ['flag' => 'update_success']);
        } else {
            $this->error($flag);
        }

    }

    public function delete()
    {
        $id = $this->request->post('id');
        DataTemplateModel::destroy($id);
        return self::ajaxMsg();
    }
}