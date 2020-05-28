<?php
require_once("kadai_4_1_db.php");
$db = db_connect();

$token = hash('sha256',uniqid(rand(),1));
$url = "http://*****/kadai_4/kadai_4_1_member.php"."?token=".$token;

if (!empty($_POST["mail"])) {
	$mail = $_POST["mail"];
	if(filter_var($mail, FILTER_VALIDATE_EMAIL) ){
		try{
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt1 = $db->prepare("SELECT * FROM premember WHERE mail=(:mail) AND flag=0");
			$stmt1->bindValue(':mail', $mail, PDO::PARAM_STR);
			$stmt1->execute();
			foreach ($stmt1 as $row1) {
			}
			$premail = $row1["mail"];
			$row_count = $stmt1->rowCount();
		
			$stmt2 = $db->prepare("SELECT * FROM member WHERE mail=(:mail) AND flag=1");
			$stmt2->bindValue(':mail', $mail, PDO::PARAM_STR);
			$stmt2->execute();
			foreach ($stmt2 as $row2) {
			}
			$Lmail = $row2["mail"];

			if ($premail == $mail && $row_count == 3) {
				$message4 = null;
				$message5 = null;
				$message6 = "$mail 宛に既に送信制限の3回メールを送信しました。<br />1日以上時間を置いてから他のメールで試してください。";
			} elseif ($Lmail == $mail) {
				$message4 = "$mail は既に本登録されているのでメールを送信できません。";
				$message5 = null;
				$message6 = null;
			} else {
				$stmt = $db->prepare("INSERT INTO premember (mail,token,date) VALUES (:mail,:token,now())");
				$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
				$stmt->bindValue(':token', $token, PDO::PARAM_STR);
				$stmt->execute();
				$db = null;	

				$mailTo = $mail;
				$returnMail = 'keijiban@sample.com';
				$Fname = "簡易掲示板運営";
				$Fmail = 'keijiban@sample.com';
				$subject = "-簡易掲示板-認証メール-";

$body = <<< EOM
24時間以内に下記のURLからご登録下さい。
{$url}
EOM;

				mb_language('ja');
				mb_internal_encoding('UTF-8');
				$header = 'From: ' . mb_encode_mimeheader($Fname). ' <' . $Fmail. '>';
				if (mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)) {
					$message4 = null;
					$message5 = "$mail にメールを送信しました。24時間以内にメールに記載されたURLから登録ページへアクセスし、登録して下さい。";
					$message6 = null;
				} else {
					$message5 = "メールの送信に失敗しました。";
				}	
			}
			$message1 = null;
		}catch (PDOException $e){
			$message1 = "Error";
			die();
		}
		$message1 = null;
		$message3 = null;
	}else{
		$message1 = null;
		$message3 = "$mail は不正な形式のメールアドレスです";
		$message4 = null;
		$message5 = null;
		$message6 = null;
	}
	$message1 = null;
	$message2 = null;
} else {
	$message1 = null;
	$message2 = "入力欄に空欄があります。";
	$message3 = null;
	$message4 = null;
	$message5 = null;
	$message6 = null;
}

define('SMARTY_DIR', '/home/*****/public_html/kadai_4/smarty/');
define('SMARTY_TMPL_DIR', '/home/*****/public_html/kadai_4/templates/');
define('SMARTY_COMPILE_DIR', '/home/*****/public_html/kadai_4/templates_c/');

require_once(SMARTY_DIR.'Smarty.class.php');

$smarty = new Smarty();

$smarty->template_dir = SMARTY_TMPL_DIR;
$smarty->compile_dir = SMARTY_COMPILE_DIR;

$template = 'kadai_4_1_mailc.tpl';
$smarty->assign('message1',$message1);
$smarty->assign('message2',$message2);
$smarty->assign('message3',$message3);
$smarty->assign('message4',$message4);
$smarty->assign('message5',$message5);
$smarty->assign('message6',$message6);
$smarty->display($template);