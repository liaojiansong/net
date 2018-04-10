<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 22:19
 */

namespace app\index\model;


use app\common\BaseModel;


class User extends BaseModel
{
    protected $table = 'user';
    // 可写入字段
    protected static $fillable = ['username', 'email', 'phone', 'password'];

    public static function createUser($param)
    {
        $user = self::create($param, self::$fillable);
        if (isset($user->id)) {
            return $user->id;
        } else {
            return false;
        }
    }
}