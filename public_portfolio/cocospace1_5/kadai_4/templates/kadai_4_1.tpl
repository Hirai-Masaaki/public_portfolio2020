<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="comn/kadai_4_1.css">
    <link rel=”icon” href=“favicon.ico”>
    <title>-簡易掲示板-</title>
    <style>
      {if $agent_smart}
        body{
          background: #e3fffd;
        }
      {elseif $agent_pc}
        body{
          background: #e5ffdb;
        }
      {elseif $agent_future}
        body{
          background: #ffe7fb;
        }
      {/if}
      {nocache}
      {if $name}
        header nav button {
          display: none;
        }
        header li + li + li button {
          display: block; 
        }
        header nav ul + ul li {
          float: left;
        }
      {else}
        header li + li +li button,
        .upfile,
        .notes {
          display: none; 
        }
      {/if}
      {/nocache}
    </style>
	</head>
	<body>
    <header>
      <h1><a href="">-簡易掲示板-</a></h1>
      <nav>
        <ul>
          <li><a href="">TOPページ</a></li>
        </ul>
        <ul>
          <li><button><a href="kadai_4_1_login.html">ログイン</a></button></li>
          <li><button><a href="kadai_4_1_mail.html">会員登録</a></button></li>
          <li><button><a href="kadai_4_1_logout.php">ログアウト</a></button></li>
        </ul>
        <ul class="message1">
          <li>{nocache}{$message1}{/nocache}</li>
        </ul>
      </nav>
    </header>
    <div>
      <main>
        <section>
          <h3>-投稿一覧-</h3>
          <div class="post">
          {* {nocache} *}
            {foreach $stmt as $row}
              <p>{$row['id']}　{$row['name']}　{$row['date']}<br />　{$row['comment']}</p>
              {if $row['extension'] === "jpeg" || $row['extension'] === "png" || $row['extension'] === "gif"}
                <div class="media">　<img src="{$row['file_path']}" width="100px" height="80px"></div>
              {elseif $row['extension'] === "mp4" || $row['extension'] === "avi" || $row['extension'] === "mov"}
                <div class="media">　<video src="{$row['file_path']}" width="280px" height="200px" controls></video></div>
              {/if}
            {/foreach}
          {* {/nocache} *}
          </div>
        </section>
        <section class="margin-bottom">
          <h3>-入力フォーム-<span class="message">{nocache}{$message2}{$message3}{$message4}{$message5}{$message6}{$message7}{/nocache}</span></h3>
          <div class="boxes">
            <div class="box1">
              <form action="" method="POST" enctype="multipart/form-data">
                <input id="edit_num" type="hidden" readonly name="edit_num" min="1" value="{nocache}{$edit}{/nocache}">
                <h4>新規投稿</h4>
                <input id="comment" typr="text" name="comment" {nocache}{$readonly}{/nocache} maxlength="50" placeholder="※Enterで送信可。50文字まで" value="{nocache}{$edit_comment}{/nocache}"><br />
                <p class="notes">※投稿可能なファイルは8.3MBまでです。</p>
                <input class="upfile" type="file" name="upfile" accept="image/*,video/*"><br />
                <input type="submit" name="btn_submit" value="送信">
              </form>
            </div>
            <div class="box2">
              <h4>投稿編集</h4>
              <form action="" method="POST">
                <input id="edit" type="number" name="edit" {nocache}{$readonly}{/nocache} min="1" placeholder="編集する投稿番号">
                <br />
                <input type="submit" name="btn_edit" value="編集内容送信"><br />
                <input type="hidden" name="Emode" value="edit">
              </form>
            </div>
            <div class="box3">
              <h4>投稿削除</h4>
              <form action="" method="POST">
                <input id="delete_num" type="number" name="delete_num" {nocache}{$readonly}{/nocache} min="1" placeholder="削除する投稿番号">
                <br />
                <input type="submit" name="btn_delete" value="削除"><br />
                <input type="hidden" name="Dmode" value="delete_num">
              </form>
            </div>
          </div>
        </section>
      </main>
      <footer>
        <small>この掲示板は課題で作成しました。<br />©2020 HiraiMasaaki</small>
      </footer>
    </div>
  </body>
</html>