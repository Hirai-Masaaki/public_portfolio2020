<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="comn/kadai_4_1.css">
    <title>-簡易掲示板-入力確認-</title>
    <style>
      {if $name === null || $password === null || $message2}
        .none {
          display: none;
        }
      {/if}
    </style>
	</head>
	<body>
    <header>
      <h1><a href="kadai_4_1.php">-簡易掲示板-</a></h1>
      <nav>
        <ul>
          <li><a href="kadai_4_1.php">TOPページ</a></li>
        </ul>
      </nav>
    </header>
    <div>
      <main>
        <h2>-入力確認-</h2>
        <section>
          <h3 class="margin-top">{$message1}{$message2}</h3>
          <form action="kadai_4_1_memberd.php" method="POST">
          <label for="name">名前：<br /></label>
            <input id="name" type="text" name="name" value="{$name}" readonly>
            <br />
            <label for="password">パスワード：<br /></label>
            <input id="password" type="password" name="password" value="{$password}" readonly>
            <br />
            <input type="button" value="戻る" onclick="history.back()">
            <input class="none" type="submit" name="btn_submit" value="登録する">
          </form>
        </section>
      </main>
    </div>
  </body>
</html>