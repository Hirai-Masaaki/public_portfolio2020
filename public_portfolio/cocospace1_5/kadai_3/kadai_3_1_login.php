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
          <ul>
            <li><button class="sub"><a href="kadai_3_1_mail.php">会員登録</a></button></li>
          </ul>
        </nav>
    </header>
    <div>
      <main>
        <h2>-ログイン-</h2>
        <section>
          <h3 class="margin-top">IDとパスワードを入力し、ログインしてください。</h3>
          <form action="kadai_3_1_loginc.php" method="POST">
            <label for="uid">ID：<br /></label>
            <input id="uid" type="text" name="uid" maxlength="13" value="">
            <br />
            <label for="password">パスワード：<br /></label>
            <input id="password" type="password" name="password" maxlength="12">
            <br />
            <input type="submit" name="btn_submit" value="ログイン">
          </form>
        </section>
      </main>
    </div>
  </body>
</html>