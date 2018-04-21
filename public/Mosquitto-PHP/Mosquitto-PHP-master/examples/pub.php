<?php

$client = new Mosquitto\Client();
$client->onConnect('on_connect');
$client->onDisconnect('on_disconnect');
$client->onSubscribe('on_subscribe');
$client->onMessage('on_message');
// 连接到主机
$client->connect("localhost", 1883, 5);
// 订阅主题
$client->subscribe('hello', 1);

while (true) {
    // 保持通讯
    $client->loop();
    $mid = $client->publish('hello', "小伙伴你好啊,现在的时间是" . date('Y-m-d H:i:s'), 1, false);
    echo "发送我的第{$mid} 小消息\n";
    // 继续保持通讯
    $client->loop();

    sleep(2);
}
// 关闭连接
$client->disconnect();
unset($client);

function on_connect($r)
{
    echo "我是连接成功时的回调函数,服务器响应代码为{$r}\n";
}

function on_subscribe()
{
    echo "服务器了我的响应订阅一个主题请求,所以我被调用了\n";
}

function on_message($message)
{
    printf("收到一条消息 %d 来自主体 %s 消息内容是:\n%s\n\n", $message->mid, $message->topic, $message->payload);
}


function on_disconnect($rc)
{
    echo "哎呀,连接断开了,服务器响应代码为{$rc}\n";
}
