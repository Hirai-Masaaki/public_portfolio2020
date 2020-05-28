<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="comn/kadai_4_1.css">
    <title>-簡易掲示板-本登録-</title>
    <style>
      {if $message1 || $message2 || $message3}
        section {
          display: none;
        }
      {else}
        .caution {
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
        <h2>-本登録-</h2>
        <h3 class="caution">{$message1}{$message2}{$message3}</h3>
        <section>
          <h3 class="margin-top">ユーザー情報を入力し、登録してください。</h3>
          <form action="kadai_4_1_memberc.php" method="POST">
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