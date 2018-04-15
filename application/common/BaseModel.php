<?php
/**
 * Created by PhpStorm.
 * UserModel: Administrator
 * Date: 2018/4/8
 * Time: 22:19
 */

namespace app\common;


use think\Model;

class BaseModel extends Model
{
    protected static $fillable = null;

    /**
     * 新的创建方法
     * @param $param
     * 传入的变量
     * @return bool|mixed
     */
    public static function newCreate($param)
    {
        $user = self::create($param, self::$fillable);
        if (isset($user->id)) {
            return $user->id;
        } else {
            return false;
        }
    }

    /**
     * 新的更新方法
     * @param $id
     * 要更新的id
     * @param $param
     * 更新的变量
     */
    public function newUpdate($id, $param)
    {
        $instance = new self();
        $instance->allowField(self::$fillable)->save($param, ['id' => $id]);
    }

}