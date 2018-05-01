<?php
/**
 * 报警类
 * @User: Jason
 * @Date: 2018/4/26
 */
require_once('Base.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

//require '../../vendor/phpmailer/phpmailer/src/Exception.php';
//require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
//require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
class Report extends Base
{
    /**
     * 发送邮件
     * @param $target_info
     */
    public function sendEmail()
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'liao_jian_song@163.com';                 // SMTP username
            $mail->Password = 'liao325339';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('liao_jian_song@163.com', 'Mailer');
            $mail->addAddress('729631422@qq.com', 'Joe User');     // Add a recipient
            $mail->addReplyTo('729631422@qq.com', 'Information');



            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }

    /**
     * 报告发送邮件的结果(写进数据表)
     */
    public function responseEmailResult()
    {

    }

    public function getReportInfo()
    {
        // todo 每一个target_device 包含完成的报警信息
        $report_key = 'report_list';
        $len = $this->redis->lLen($report_key);
        if ($len > 1) {
            for ($i = 0; $i < $len; $i++) {
                $one_target_device = $this->redis->rPop($report_key) ?? null;
                if ($one_target_device != null) {
                    if ($this->redis->exists($one_target_device))
                    $target_info = $this->redis->hGetAll($one_target_device);
                    $this->sendEmail($target_info);
                }
            }
        }
    }
}

$obj = new Report();
$obj->sendEmail();
echo "done";