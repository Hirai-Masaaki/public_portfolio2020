<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="comn/kadai_4_1.css">
    <title>-簡易掲示板-本登録完了-</title>
	</head>
	<body>
    <header>
      <h1><a href="kadai_4_1.php">-簡易掲示板-</a></h1>
      <nav>
        <ul>
          <li><a href="kadai_4_1.php">TOPページ</a></li>
        </ul>
        <ul>
          <li><button><a href="kadai_4_1_login.html">ログイン</a></button></li>
        </ul>
      </nav>
    </header>
    <div>
      <main>
        <h2>-本登録完了-</h2>
        <section>
          <h3 class="margin-top">ユーザー情報</h3>
          <div>
            <p class="user_info">ID:{$uid}</p>
            <p class="user_info">名前:{$name}</p>
            <p class="user_info">パスワード:セキュリティ保護のため、表示されません。</p>
            <p class="user_info">メールアドレス:{$mail}</p>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>