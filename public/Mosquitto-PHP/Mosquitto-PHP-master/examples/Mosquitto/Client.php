<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 16:06
 */

namespace Mosquitto;


class Client
{
    /**
     * Client constructor.
     * @param $id (string)
     * 客户端ID,如果省略或者为null,会随机生成一个。
     * @param $cleanSession (boolean)
     * 如果设为false ，当 client 断开连接后，broker 会保留该 client 的订阅和消息，直到再次连接成功；如果设为 true（默认） ，client 断开连接后，broker 会将所有的订阅和消息删除。
     */
    public function __construct($id = 'jason', $cleanSession = true)
    {

    }

    /**
     * 设置连接到服务器的用户名和密码。必须在connect之前调用.
     * @param $username (string)
     * 连接到代理的用户名。
     * @param $password (string)
     * 连接到代理的密码。
     */
    public function setCredentials($username, $password)
    {

    }

    /**
     * 设置“遗嘱消息”，当 broker 检测到网络故障、客户端异常等问题，需要关闭某个客户端的连接时，向该客户端发布一条消息。必须在connect之前调用.
     * @param $topic
     * 发表遗嘱消息的主题。
     * @param $payload
     * 要发送的数据。
     * @param int $qos
     * 可选。服务质量。默认值为0.整数0,1或2。
     * @param bool $retain
     * 可选。默认为false。设置为true，则该消息将被保留。
     */
    public function setWill($topic, $payload, $qos = 0, $retain = false)
    {

    }

    /**
     * 删除之前设置遗嘱消息。没有参数
     */
    public function clearWill()
    {

    }

    /**
     * 设置客户端在Client::loopForever中意外断开连接时的行为。如果不使用此方法的默认行为是反复尝试以1秒的延迟重新连接，直到连接成功。
     * @param $reconnectDelay (int)
     * 设置尝试连续连接之间的时间间隔。
     * @param $exponentialDelay (int)
     * 当启用指数回退时，在连续的重新连接尝试之间设置最大延迟
     * @param $exponentialBackOff (bool)
     * 通过真正的启用指数回退
     */
    public function setReconnectDelay($reconnectDelay, $exponentialDelay, $exponentialBackOff)
    {

    }

    /**
     * 服务器断开。没有参数。
     */
    public function disconnect()
    {

    }

    /**
     * 设置连接回调。当代理发送connectionBack消息来响应连接时被触发
     * @param callable $callback
     * 回调应该采取以下形式的参数
     * $rc (int)– 来自服务器的响应代码。
     * $message (string)– 响应代码的字符串描述。
     */
    public function onConnect(callback $callback)
    {

    }

    /**
     * 设置断开连接回调。当服务器收到断开连接命令并断开客户端连接时被触发
     * @param callable $callback
     * 回调应该采取以下形式的参数
     * $rc (int) – 断开的原因。0表示客户端请求断开。其他任何值表示意外断开连接。
     */
    public function onDisconnect(callback $callback)
    {

    }

    /**
     * 设置日志记录回调。
     * @param callable $callback
     * $level (int) – 日志消息级别
     * $str (string) – 消息字符串。
     * 该级别可以是以下之一：
     * Client::LOG_DEBUG
     * Client::LOG_INFO
     * Client::LOG_NOTICE
     * Client::LOG_WARNING
     * Client::LOG_ERR
     */
    public function onLog(callback $callback)
    {

    }

    /**
     * 设置订阅回调。服务器响应订阅请求时被调用。
     * @param callable $callback
     * 回调应该采取以下形式的参数：
     * Parameters:
     * $mid (int) – 订阅消息的消息ID。
     * $qosCount (int) – 授予订阅的数量。
     */
    public function onSubscribe(callback $callback)
    {

    }

    /**
     * 设置消息回调。收到从服务器返回的消息时调用。
     * @param callable $callback
     * 回调函数
     * Parameters:
     * 回调应该采取以下形式的参数：
     * $msg 是一个对象
     */
    public function onMessage(callback $callback)
    {

    }

    /**
     * 设置取消订阅回调。服务器响应取消订阅请求时被调用。
     * @param $callback
     * 回调应该采取以下形式的参数：
     * Parameters:
     *
     * $mid (int) – 取消订阅消息的消息ID
     */
    public function onUnsubscribe($callback)
    {

    }

    /**
     * 设置发布回调。当客户端自己发布消息时调用
     * @param $callback
     * 回调函数
     * Warning: 这可能会在publish之前调用返回消息ID，所以，你需要创建一个队列来处理中间列表。
     * 回调应该采取以下形式的参数：
     * Parameters:
     *
     * $mid (int) –publish 返回的消息ID
     */
    public function onPublish($callback)
    {

    }

    /**
     * 设置重发消息之前要等待的秒数。这适用于发布qos> 0的消息。可能随时被调用
     * @param $messageRetryPeriod
     * 重发间隔
     */
    public function setMessageRetry($messageRetryPeriod)
    {

    }

    /**
     * 发布主题消息
     * @param $topic
     * 要发表的主题
     * @param $payload
     * 消息体
     * @param int $qos
     * 服务质量，0,1或2
     * @param bool $retain
     * 是否保留此消息，默认为false
     * @return int
     * 服务器返回该消息ID（警告：消息ID并不是唯一的）。
     */
    public function publish($topic, $payload, $qos = 0, $retain = false)
    {
        return $topic + 1;

    }

    /**
     * 连接主机
     * @param $host
     * 连接的主机名
     * @param int $port
     * 可选。 要连接的端口号。默认为1883
     * @param int $keepalive
     * 在没有收到消息的情况下，服务器应该ping客户端的次数
     * @param null $interface
     * 可选。要为此连接绑定的本地接口的地址或主机名。
     */
    public function connect($host, $port = 1883, $keepalive = 60, $interface = null)
    {

    }

    /**
     * 订阅一个主题
     * @param $topic
     * 主题字符串
     * @param $qos
     * 服务质量
     */
    public function subscribe($topic, $qos)
    {

    }

    /**
     * 客户端主网络循环，必须调用该函数来保持 client 和 broker 之间的通讯。收到或者发送消息时，它会调用相应的回调函数处理。当 QoS>0 时，它还会尝试重发消息
     * @param int $timeout
     * 等待网络活动的毫秒数。传递0即时超时。默认为1000。
     */
    public function loop($timeout = 1000)
    {

    }

    /**
     * 在无限的阻塞循环调用loop()，将根据需要调用回调。这将处理重新连接，如果连接丢失。调用disconnect在回调断开，并从循环中返回。或者，调用exitloop退出循环而不断开。您将需要再次重新进入循环以保持连接
     * @param int $timeout
     * 等待网络活动的毫秒数。传递0即时超时。默认为1000。
     */
    public function loopForever($timeout = 1000)
    {

    }

    /**
     * 退出loopforever事件循环而不断开连接。你将需要重新进入循环以保持连接
     */
    public function exitLoop()
    {

    }
}