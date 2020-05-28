<?php
require_once("kadai_3_1_db.php");
$db = db_connect();

if (!empty($_POST["name"]) && !empty($_POST["password"])) {
  $name = $_POST["name"];
  $password = $_POST["password"];
  try{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare("SELECT * FROM member WHERE name=(:name) AND flag=1");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt as $row) {
    }
    $Lname = $row["name"];
    if ($Lname == $name) {
      $message1 = null;
      $message2 = "既に入力された名前は使われています。";
    } else {
      $message1 = "入力内容を確認し、問題なければ確認ボタンを押してください。";
      $message2 = null;
    }
  }catch (PDOException $e){
    echo "Error";
    die();
  }
} else {
  $message1 = "入力欄に空欄があります。";
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="kadai_3_1.css">
    <title>-簡易掲示板-入力確認-</title>
    <style>
      <?php if (empty($_POST["name"]) || empty($_POST["password"]) || !empty($message2)){ ?>
        .none {
          display: none;
        }
      <?php } ?>
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
        <h2>-入力確認-</h2>
        <section>
          <h3 class="margin-top"><?= $message1 . $message2 ?></h3>
          <form action="kadai_3_1_memberd.php" method="POST">
          <!-- 名前 -->
          <label for="name">名前：<br /></label>
            <input id="name" type="text" name="name" value="<?= $name ?>" readonly>
            <br />
            <!-- 保存時パスワード -->
            <label for="password">パスワード：<br /></label>
            <input id="password" type="password" name="password" value="<?= $password ?>" readonly>
            <br />
            <input type="button" value="戻る" onclick="history.back()">
            <input class="none" type="submit" name="btn_submit" value="登録する">
          </form>
        </section>
      </main>
    </div>
  </body>
</html>