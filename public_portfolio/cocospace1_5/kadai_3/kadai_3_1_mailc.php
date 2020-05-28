<?php
require_once("kadai_3_1_db.php");
$db = db_connect();

$token = hash('sha256',uniqid(rand(),1));
$url = "http://*****/kadai_3/kadai_3_1_member.php"."?token=".$token;

if (!empty($_POST["mail"])) {
	$mail = $_POST["mail"];
	if(filter_var($mail, FILTER_VALIDATE_EMAIL) ){ //形式が正しければ
		try{
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$stmt1 = $db->prepare("SELECT * FROM premember WHERE mail=(:mail) AND flag=0");
			$stmt1->bindValue(':mail', $mail, PDO::PARAM_STR);
			$stmt1->execute(); //終了
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
			} elseif ($Lmail == $mail) { //登録されているアドレスと入力したアドレスが一致するなら
				$message4 = "$mail は既に本登録されているのでメールを送信できません。";
				$message5 = null;
				$message6 = null;
			} else { //一致しないなら
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
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="kadai_3_1.css">
    <title>-簡易掲示板-メール送信-</title>
	</head>
	<body>
		<header>
			<h1><a href="kadai_3_1.php">-簡易掲示板-</a></h1>
			<nav>
				<ul>
					<li><a href="kadai_3_1.php">TOPページ</a></li>
				</ul>
			</nav>
		</header>
		<div>
      <main>
        <h2>-メール送信-</h2>
        <section>
					<!-- 1どれも当てはまらない -->
					<!-- 2空欄 -->
					<!-- 3形式間違い -->
					<!-- 4登録済みかどうか -->
					<!-- 5メールの送信できたかどうか -->
					<h3 class="margin-top"><?= $message1 . $message2 . $message3 . $message4 . $message5 . $message6 ?></h3>
					<p><input type="button" value="戻る" onclick="history.back()"></p>
        </section>
      </main>
		</div>
  </body>
</html>