<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="kadai_3_1.css">
    <title>-簡易掲示板-仮登録-</title>
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
        <h2>-仮登録-</h2>
        <section>
          <h3 class="margin-top">
          本登録のための認証URLを添付したメールを送信します。<br />
          確認できるメールアドレスを入力してください。
          </h3>
          <form action="kadai_3_1_mailc.php" method="POST">
            <label for="mail">メールアドレス：<br /></label>
            <input id="mail" type="text" name="mail" placeholder="メールアドレス">
            <br />
            <input type="submit" name="btn_submit" value="送信する">
          </form>
        </section>
      </main>
    </div>
  </body>
</html>