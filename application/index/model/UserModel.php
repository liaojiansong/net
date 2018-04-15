<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/4/8
 * Time: 22:19
 */

namespace app\index\model;


use app\common\BaseModel;


class UserModel extends BaseModel
{
    protected $table = 'user';
    // 可写入字段
    protected static $fillable = ['username', 'email', 'phone', 'password'];

}