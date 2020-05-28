<?php
session_start();

require_once("kadai_3_1_db.php");
$db = db_connect();

try{
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (!empty($_POST["uid"]) && !empty($_POST["password"])) {
    $uid = $_POST["uid"];
    $password = $_POST["password"];

    $stmt = $db -> prepare("SELECT * FROM member WHERE uid=(:uid) AND flag=1");
    $stmt->bindValue(':uid', $uid, PDO::PARAM_STR); //:uidはPOSTで送信されたuid
    $stmt->execute(); //終了
    foreach ($stmt as $row) {
    }
    $Lpassword = $row["password"];
    if ($Lpassword == $password) {
      $Lname = $row["name"]; //その行のnameに保存されている値を$Lnameに代入
      $_SESSION["name"] = $Lname;
      $_SESSION["password"] = $Lpassword;
      $message3 = null;
      header("Location: kadai_3_1.php");
      exit();
    } else {
      $message3 = "入力内容が登録内容と一致していません。";
      // header("Location: kadai_3_1_login.php");
      // exit();
    }
    $message2 = null;
    $message3 = null;
  } else {
    $message2 = "入力欄に空欄があります。";
    $message3 = null;
    // header("Location: kadai_3_1_login.php");
    // exit();
  }
  $message1 = null;
}catch(PDOException $e){
  $message1 = "Error";
  die();
}
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="kadai_3_1.css">
    <title>-簡易掲示板-ログイン-</title>
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
        <h2>-ログイン失敗-</h2>
        <section>
          <h3 class="margin-top"><?= $message1 . $message2 . $message3 ?></h3>
          <p><input type="button" value="戻る" onclick="history.back()"></p>
        </section>
      </main>
    </div>
  </body>
</html>