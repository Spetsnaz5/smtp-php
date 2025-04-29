<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {

    $to = $_ENV['SMTP_FROM'];

    $mail = new PHPMailer(true);
    // 設定 SMTP
    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USERNAME'];
    $mail->Password   = $_ENV['SMTP_PASSWORD'];//Gmail 應用程式密碼，不是登入密碼，來源 Google 帳戶 > 安全性 > 應用程式密碼
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // 收發件人設定
    $mail->setFrom($_ENV['SMTP_FROM'], $_ENV['SMTP_FROM_NAME']);
    $mail->addAddress($to);

    // 內容設定
    $mail->isHTML(true);
    $mail->Subject = '這是信件標題';
    $mail->Body    = '這是 <b>信件內容</b>';
    $mail->AltBody = '純文字版內容';

    if (! $mail->send())
        throw new Exception($mail->ErrorInfo);

    echo "寄信成功";
} catch (Exception $e) {
    echo "寄信失敗: {$e->getMessage()}";
}
