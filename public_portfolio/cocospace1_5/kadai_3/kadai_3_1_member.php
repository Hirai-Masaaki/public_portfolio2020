<?php
session_start();

require_once("kadai_3_1_db.php");
$db = db_connect();

if(!empty($_GET)) {
  $token = $_GET["token"];
  try{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("SELECT token FROM member WHERE token=(:token) AND flag =1");
    $stmt->bindValue(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt as $row){}
    $mem_token = $row['token'];
    if ($token == ''){
      $message1 = "もう一度登録をやりなおして下さい。";
      $message2 = null;
      $message3 = null;
    } elseif ($mem_token == $token) {
      $message1 = null;
      $message2 = "既に登録されています。";
      $message3 = null;
    } else {
      $message1 = null;
      $message2 = null;
      $message3 = null;

      $stmt = $db->prepare("SELECT mail FROM premember WHERE token=(:token) AND flag =0 AND date > now() - interval 24 hour");
      $stmt->bindValue(':token', $token, PDO::PARAM_STR);
      $stmt->execute();
      
      $row_count = $stmt->rowCount();
      if( $row_count ==1){
        $mail_array = $stmt->fetch();
        $mail = $mail_array["mail"];
        $_SESSION['mail'] = $mail;
        $_SESSION['token'] = $token;
        $message3 = null;
      }else{
        $message3 = "このURLは利用できません。";
      }
      $db = null;
    }
  }catch (PDOException $e){
    die();
  }
}
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="kadai_3_1.css">
    <title>-簡易掲示板-本登録-</title>
    <style>
      <?php if (!empty($message1) || !empty($message2) || !empty($message3)) : ?>
        section {
          display: none;
        }
      <?php endif ?>
    </style>
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
        <h2>-本登録-</h2>
        <h3><?= $message1 . $message2 . $message3 ?></h3>
        <section>
          <h3 class="margin-top">ユーザー情報を入力し、登録してください。</h3>
          <form action="kadai_3_1_memberc.php" method="POST">
            <!-- 名前 -->
            <label for="name">名前：<br /></label>
            <input id="name" type="text" name="name" maxlength="12" value="" placeholder="12文字まで">
            <br />
            <!-- 保存時パスワード -->
            <label for="password">パスワード：<br /></label>
            <input id="password" type="password" name="password" maxlength="12" placeholder="12文字まで">
            <br />
            <!-- 送信ボタン -->
            <input type="submit" name="btn_submit" value="確認する">
          </form>
        </section>
      </main>
    </div>
  </body>
</html>