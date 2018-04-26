<?php
/**
 * 项目: net
 * 作者: Jason
 * 日期: 2018/4/25
 * 时间: 21:20
 */

namespace app\index\model;


use app\common\BaseModel;

class ProductModel extends BaseModel
{
    protected $table = 'products';
    // 可写入字段
    protected static $fillable = ['product_name', 'product_industry', 'product_description'];

    public static function newCreate($param, $fillable = null)
    {
        return parent::newCreate($param, self::$fillable); // TODO: Change the autogenerated stub
    }

    public function newUpdate($id, $param)
    {
        $instance = new self();
        $instance->allowField(self::$fillable)->save($param, ['id' => $id]);
    }

    public function devices()
    {
        return $this->hasMany('DevicesModel', 'product_id');
    }

}