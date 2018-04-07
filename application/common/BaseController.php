<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/7
 * Time: 10:20
 */

namespace app\common;


use think\Controller;
use think\Request;
use function in_array;
use function strtolower;

class BaseController extends Controller
{
    protected static $auth = ['index/index/index'];


    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * 提示信息
     * @param bool $is_success
     * 是否成功,默认为true
     * @param string $msg
     * 提示信息
     * @return array
     * 返回提示信息
     */
    public static function ajaxMsg($is_success = true, $msg = '操作成功')
    {
        return [
            'flag' => $is_success,
            'msg' => $msg,
        ];
    }

    public function validateAuth()
    {

        /*
         * 权限控制
         * 1 验证顺序 模块->控制器->方法
         * 2 表设计 auth
         *   id   |  control  |  title
         * (1) 获取当前用户可接触的module/controller/action md5加密并存入session中
         * (2) 依次检验用户是否在这些数组里面
         */
        $path_info = $this->request->module() . '/' . $this->request->controller() . '/' . $this->request->action();
        if (in_array(strtolower($path_info), self::$auth)) {

        } else {

        }

    }

}