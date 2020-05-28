<?php
session_start();

require_once("kadai_3_1_db.php");
$db = db_connect();

$name = $_POST['name'];
$password = $_POST['password'];
$mail = $_SESSION["mail"];
$token = $_SESSION["token"];
// $password_hash =  password_hash($password, PASSWORD_DEFAULT);
if (!empty($name) && !empty($password)) {
  $uid = uniqid();
  try{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $db->prepare("INSERT INTO member (uid,name,password,mail,token) VALUES (:uid,:name,:password,:mail,:token)");
    $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
    $stmt->bindValue(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $stmt = $db->prepare("UPDATE premember SET flag=1 WHERE mail=(:mail)");
    $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
    $stmt->execute();
    $db = null;	
  }catch (PDOException $e){
    $message = "Error!";
    die();
  }
    
  $url = "http://*****/kadai_3/kadai_3_1_login.php";
  $mailTo = $mail;
  $returnMail = 'keijiban@sample.com';
  $Fname = "簡易掲示板運営";
  $Fmail = 'keijiban@sample.com';
  $subject = "-簡易掲示板-会員登録完了-";
    
$body = <<< EOM
会員登録が完了しました！
--------------------
-ユーザー情報-
ID : $uid
名前 : $name
パスワード : セキュリティ保護のため、表示されません。
メールアドレス : $mail
--------------------
下記URLから掲示板ログインページへアクセスできます。
{$url}
EOM;
  
  mb_language('ja');
  mb_internal_encoding('UTF-8');
  $header = 'From: ' . mb_encode_mimeheader($Fname). ' <' . $Fmail. '>';
  if (mb_send_mail($mailTo, $subject, $body, $header, '-f'. $returnMail)) {
    $_SESSION = array();
      session_destroy();
  }	
} else {
  $message = "本登録をやり直してください。";
}
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="kadai_3_1.css">
    <title>-簡易掲示板-本登録完了-</title>
	</head>
	<body>
    <header>
      <h1><a href="kadai_3_1.php">-簡易掲示板-</a></h1>
      <nav>
        <ul>
          <li><a href="kadai_3_1.php">TOPページ</a></li>
        </ul>
        <ul>
          <li><button><a href="kadai_3_1_login.php">ログイン</a></button></li>
        </ul>
      </nav>
    </header>
    <div>
      <main>
        <h2>-本登録完了-</h2>
        <section>
          <h3 class="margin-top">ユーザー情報</h3>
          <p>ID:<?= $uid ?></p>
          <p>名前:<?= $name ?></p>
          <p>パスワード:セキュリティ保護のため、表示されません。</p>
          <p>メールアドレス:<?= $mail ?></p>
        </section>
      </main>
    </div>
  </body>
</html>