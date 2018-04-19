<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/19
 * Time: 22:58
 */

$redis = new Redis();
$redis->connect('127.0.0.1');
while (true) {

    $devices = $redis->keys('^H_devices_');
    $device_data_box = [];
    foreach ($devices as $value) {
        // 先取到达长度的,若它快过期,下一个if的值就会覆盖它,保障数据准确性
        if ($redis->lLen($value) > 5000) {
            $device_data_box[$value] = $redis->getRange($value, 0, -1);
        }
        // 过期时间
        if (-1 < $redis->ttl($value < 5)) {
            //剪切走这一部分数据
            $device_data_box[$value] = $redis->getRange($value, 0, -1);
        }
    }

    $mysql = new mysqli();
    $mysql->connect('127.0.0.1', 'root', '123456', 'jasonnet');

    // 获取触发器信息
    $sql = "select 'device_id' 'max' 'min' 'eq' from TriggerBox ";

    $triggers = $mysql->query($sql);


    $warning_box = [];
    // TODO 同一个设备可能有多个触发条件
    foreach ($device_data_box as $key => $val) {
        if ($key === $triggers['key']) {
            foreach ($val as $need_check) {
                if ($val > $triggers['value']) {
                    // 装入警报箱
                    $warning_box[$key] = [
                        // 事件
                        'condition' => '>',
                        // 值
                        'value' => $val,
                    ];
                }
            }
        }
    }

    // 处理报警事件
    foreach ($warning_box as $dev => $val) {
        // TODO 通过mysql去查报警的email 然后发送email
        // TODO 或者去查询此时应该执行的命令啊
        echo $val;
    }

    sleep(5);

}