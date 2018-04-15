<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/4/14
 * Time: 15:59
 */

namespace app\index\model;


use app\common\BaseModel;

class DevicesModel extends BaseModel
{
    protected $table = 'devices';
    // 可写入字段
    protected static $fillable = ['device_name', 'device_description', 'device_auth', 'icon'];


}