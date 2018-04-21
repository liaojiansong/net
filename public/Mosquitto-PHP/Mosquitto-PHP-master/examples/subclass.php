<?php

class MyClient extends Mosquitto\Client
{
    // 等待订阅
    protected $pendingSubs = [];
    // 授予,已经订阅
    protected $grantedSubs = [];
    // 订阅回调
    protected $subscribeCallback = null;

    public function __construct($id = null, $cleanSession = false)
    {
        // 调用父类构造函数
        parent::__construct($id, $cleanSession);
        // 被订阅时触发的函数
        parent::onSubscribe(array($this, 'subscribeHandler'));
    }

    public function subscribeHandler($mid, $qosCount, $grantedQos)
    {
        if (!isset($this->pendingSubs[$mid])) {
            return;
        }

        $topic = $this->pendingSubs[$mid];
        $this->grantedSubs[$topic] = $grantedQos;
        echo "Subscribed to topic {$topic} with message ID {$mid}\n";

        if (is_callable($this->subscribeCallback)) {
            $this->subscribeCallback($mid, $qosCount, $grantedQos);
        }
    }

    public function subscribe($topic, $qos)
    {
        $mid = parent::subscribe($topic, $qos);
        $this->pendingSubs[$mid] = $topic;
    }

    public function onSubscribe(callable $callable)
    {
        $this->subscribeHandler = $callable;
    }

    public function getSubscriptions()
    {
        return $this->grantedSubs;
    }
}

$c = new MyClient('subscriptionTest');
$c->onSubscribe(function () {
    echo "Hello, I got subscribed\n";
});
$c->connect('localhost', 1883, 50);
$c->subscribe('#', 1);

for ($i = 0; $i < 5; $i++) {
    $c->loop(10);
}

var_dump($c->getSubscriptions());

