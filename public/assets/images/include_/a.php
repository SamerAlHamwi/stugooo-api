<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
use PHPMailer\PHPMailer\Exception;
function smtp_send($host, $port, $user, $pass, $to, $subject, $fromName, $message){
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Timeout = 18;
    $mail->getSMTPInstance()->Timelimit = 15;
    $mail->SMTPDebug = 0;
    $mail->Host = $host;
    $mail->Port = $port;
    $mail->SMTPOptions = array(
       'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    $mail->SMTPAuth = true;
    $mail->Username = $user;
    $mail->Password = $pass;
    $mail->setFrom($user, $fromName);
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->msgHTML($message);
    if($mail->send()){
		$mail->smtpClose();
        return [true,''];
    }else{
		$mail->smtpClose();
        return [false,$mail->ErrorInfo];
    }
}
function smtp_auth($host, $port, $user, $pass){
    $mail = new PHPMailer; 
    $mail->Timeout = 15;
    $mail->getSMTPInstance()->Timelimit = 10;
    $mail->SMTPDebug = 0;
    $mail->Host = $host;
    $mail->Port = $port;
    $mail->SMTPOptions = array(
       'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    $mail->SMTPAuth = true;
    $mail->Username = $user;
    $mail->Password = $pass;
    if($mail->smtpConnect()){
        $mail->smtpClose();
        return [true,''];
    }else{
		$mail->smtpClose();
        return [false,$mail->ErrorInfo];
    }
}
if(isset($_GET["auth_type"])){
	if($_GET["auth_type"]==1){
		if(isset($_POST["host"]) && isset($_POST["port"]) && isset($_POST["user"]) && isset($_POST["pass"])){
			$res = smtp_auth(urldecode($_POST["host"]), $_POST["port"], urldecode($_POST["user"]), urldecode($_POST["pass"]));
			echo json_encode($res);exit();
		}
	}else{
		if(isset($_POST["host"]) && isset($_POST["port"]) && isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["to"]) && isset($_POST["subject"]) && isset($_POST["fromName"]) && isset($_POST["message"])){
			$res = smtp_send(urldecode($_POST["host"]), $_POST["port"], urldecode($_POST["user"]), urldecode($_POST["pass"]), urldecode($_POST["to"]), urldecode($_POST["subject"]), urldecode($_POST["fromName"]), urldecode($_POST["message"]));
			echo json_encode($res);exit();
		}
	}
}
echo 'none';
?>