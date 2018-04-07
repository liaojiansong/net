<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/7
 * Time: 10:20
 */

namespace app\common;


use think\Controller;

class BaseController extends Controller
{
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

}