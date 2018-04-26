<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/21
 * Time: 13:07
 */
ignore_user_abort(); // 后台运行
set_time_limit(0); // 取消脚本运行时间的超时上限
require_once('MysqliDb.php');

class DealDataAndInsert
{
    protected $mysql = null;
    protected $redis = null;

    const table = 'device_data';
    const host = '127.0.0.1';

    public function __construct()
    {
        $db = new MysqliDb(self::host, 'root', '123456', 'jasonnet');
        $this->mysql = $db;

        $redis = new Redis();
        $redis->connect(self::host);
        $this->redis = $redis;
    }

    /**
     * 获取设备数据
     * @return array
     */
    public function getDeviceDataBox()
    {
        $device_data_box = [];
        $list_keys = $this->redis->keys('data_list*');
        foreach ($list_keys as $key) {
            $one_data = [];
            $len = $this->redis->lLen($key);
            $live_time = $this->redis->ttl($key);
            if ($len > 1) {
                if ($live_time < 5) {
                    //TODO 若是该键无数据,会被自动清除,所以要留一个
                    for ($i = 1; $i < $len; $i++) {
                        array_push($one_data, $this->redis->rPop($key));
                    }
                } else {
                    // 长度低于50 就取$len长度的 ,大于就取50
                    if ($len > 50) {
                        $len = 50;
                    }
                    for ($i = 1; $i < $len; $i++) {
                        array_push($one_data, $this->redis->rPop($key));
                    }
                }
                $device_data_box[$key] = $one_data;
            }
        }
        return $device_data_box;
    }

    /*
     * 插入表数据
     */
    public function insetIntoTable($device_data_box)
    {
        foreach ($device_data_box as $val) {
            foreach ($val as $msg) {
                $msg = json_decode($msg);
                $payload = json_decode($msg->payload ?? null);
                var_dump($payload);
                if ($payload !== null) {
                    $insertData = [
                        'topic' => $msg->topic ?? null,
                        'devices_id' => $payload->devices_id ?? null,
                        'data_type' => $payload->data_type ?? null,
                        'data_content' => $payload->data_content ?? null,
                        'create_time' => $payload->create_time ?? null,
                        'update_time' => $payload->update_time ?? null,
                    ];
                    $this->mysql->insert(self::table, $insertData);
                }

            }
        }
    }

    /**
     * 循环插入数据
     */
    public function insertData()
    {
        while (true) {
            $data_box = $this->getDeviceDataBox();
            $this->insetIntoTable($data_box);
            unset($data_box);
            sleep(58);
        }
    }

}

$obj = new DealDataAndInsert();
$obj->insertData();