<!-- PHP -->
<?php 
  ini_set('display_errors', 0);

  $file = "kadai_2_1.txt"; //メインテキストファイル
  $Nfile = "kadai_2_1_n.txt"; //番号テキストファイル
  $Pfile = "kadai_2_1_p.txt"; //パスワードテキストファイル
  $name = $_POST["name"]; //送信された名前の値
  $comment = $_POST["comment"]; //送信されたコメントの値
  $date = date("Y/m/d H:i:s"); //現在日時の値
  $delete = $_POST["delete"]; //送信された削除対象番号の値
  $edit = $_POST["edit"]; //送信された編集対象番号の値
  $hidden = $_POST["Emode"]; //送信された隠れデータの値
  $edit_r = $_POST["edit_r"]; //送信された受信編集対象番号の値
  $password = $_POST["password"];//送信されたパスワードの値
  $Dpassword = $_POST["delete_password"];//送信された削除要求パスワードの値
  $Epassword = $_POST["edit_password"];//送信された削除要求パスワードの値

  // ファイルが存在しなければ、ファイル作成、あれば指定した文字列を書き込む
  if (file_exists($file)) {
  }else{
    file_put_contents($file, "■簡易掲示板へようこそ！■\n");
  }
  if (file_exists($Nfile)) {
  }else{
    file_put_contents($Nfile, "0");
  }
  if (file_exists($Pfile)) {
  }else{
    file_put_contents($Pfile, "パスワード一覧");
  }
  // ファイル読み込み・配列化
  $array = file($file);
  $Narray = file($Nfile);
  $Parray = file($Pfile);
  // 投稿番号(最終行＋1)
  $lastline = explode("<>", $array[count($array)-1]);
  $num = $lastline[0]+1;
  // コメントに含まれる改行を空文字列に変える
  $comment = str_replace(PHP_EOL, '', $comment);
  // 番号が空で、名前とコメントに文字列が入っている場合のみ行う分岐
  if (empty($edit_r) && !empty($name) && !empty($comment) && !empty($password)) {
    // 1行ずつ追加・改行({番号}<>{名前}<>{コメント}<>{時間})
    $fp = fopen($file, "a");
    fwrite($fp, $num);
    fwrite($fp, "<>");
    fwrite($fp, $name);
    fwrite($fp, "<>");
    fwrite($fp, $comment);
    fwrite($fp, "<>");
    fwrite($fp, date("Y/m/d H:i:s"));
    fwrite($fp, "<>");
    fwrite($fp, "password:");
    fwrite($fp, $password . PHP_EOL);
    fclose($fp);
    $Nfp = fopen($Nfile, "a");
    fwrite($Nfp, "<>");
    fwrite($Nfp, $num);
    fclose($Nfp);
    $Pfp = fopen($Pfile, "a");
    fwrite($Pfp, "<>");
    fwrite($Pfp, $password);
    fclose($Pfp);
  }
  // 削除対象番号の受信した値を定義
  if (!empty($delete) && !empty($Dpassword)) {
    $array = file($file);
    $Parray = file($Pfile);
    // 配列をループさせ、区切りごとの値を取得
    foreach ($array as $value){
      $exvalue = explode("<>", $value);
      foreach ($Parray as $Pvalue){
        $exvalue = explode("<>", $Pvalue);
        $Pexvalues = $exvalue[$delete];
        if ($num == $delete) {
        }else{
          if ($Pexvalues != $Dpassword){
          }else{
            $replace = array($delete => "$delete 【削除済】\n");
            $replaced = array_replace($array, $replace);
            file_put_contents($file, $replaced);
          }
        }
      }
    }
  }
  // 編集対象番号の受信した値を定義
  if (!empty($edit)) {
    $Narray = file($Nfile);
    // 配列をループさせ、区切りごとの値を取得
    foreach ($Narray as $Nvalue){
      $exvalue = explode("<>", $Nvalue);
      $exvalues = $exvalue[$edit];
      if ($exvalues == $edit) { 
        $eexvalue = explode("<>", $array[$edit]);
        $edname = $eexvalue[1];
        $edcomment = $eexvalue[2];
      }else{
        $exvalues = null;
        $edname = null;
        $edcomment = null;
      }
    }
  }else{
    $exvalues = null;
    $edname = null;
    $edcomment = null;
  }
  //編集で変更するデータが送られてきた場合
  if (!empty($edit_r) && !empty($name) && !empty($comment) && !empty($Epassword)) {
    $array = file($file);
    $Parray = file($Pfile);
    foreach ($Narray as $Nvalue){
      $exvalue = explode("<>", $Nvalue);
      $exexvalues = $exvalue[$edit_r];
      foreach ($Parray as $Pvalue){
        $exvalue = explode("<>", $Pvalue);
        $Pexvalues = $exvalue[$edit_r];
        if ($exexvalues == $edit_r && $Pexvalues == $Epassword) {
          $replace = array($edit_r => "$edit_r $name $comment $date 【編集済】\n");
          $replaced = array_replace($array, $replace);
          file_put_contents($file, $replaced);
        }else{
          $exvalues = null;
          $edname = null;
          $edcomment = null;
        }
      }
    }
  }
  // 配列をループさせ、区切りごとの値を取得
  function h($s){
		return htmlspecialchars($s, ENT_QUOTES, "UTF-8", true);
  }
  $array = file($file);
  $line = null;
  foreach ($array as $value){
    list($lnum, $lname, $lcomment, $ldate) = explode("<>", $value);
    $line.= h($lnum);
    $line.= " ";
    $line.= h($lname);
    $line.= " ";
    $line.= h($lcomment);
    $line.= " ";
    $line.= h($ldate);
    $line.= "<br />";
  }
  ?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <title>〜簡易掲示板〜</title>
    <style>
      a {
        overflow: auto;
      }
      ul, span {
        list-style: none;
        font-size: 12px;
        color: red;
      }
      dt {
        margin-left: 20px;
        font-size: 20px;
        font-weight: 600;
      }
      dd {
        margin-left: 20px;
        margin-bottom: 5px;
        width: 800px;
        height: auto;
      }
      h1, h2, label, input, textarea {
        margin-left: 15px;
      }
      textarea {
        width: 200px;
        height: 100px;
      }
      div {
        width: 800px;
        height: 300px;
        margin-top: 15px;
        margin-left: 15px;
        margin-bottom: 20px;
        background-color: #ffe0ef;
        overflow: auto;
      }
      .margin {
        margin-top: 70px;
      }
    </style>
	</head>
	<body>
    <h1>〜簡易掲示板〜</h1>
    <ul>
      <li>※1 編集番号送信時に自動で入力されます。編集をやめたい場合は、そのままの内容で送信してください。</li>
      <li>※2 投稿時に保存したパスワードを入力してください。</li>
      <li>※3 名前・コメント・保存パスワードが未入力だと書き込まれません。</li>
      <li>※4 編集・削除時に必要になります。パスワードを忘れると編集・削除が行えません。</li>
      <li>※5 再度、削除または編集することはできません。</li>
    </ul>
    <dl>
      <dt>新規投稿</dt>
      <dd>1.名前・コメント・パスワード保存を入力し、内容を確認してから送信ボタンを押してください。</dd>
      <dd>2.削除時入力欄下に投稿されていれば投稿完了です。</dd>
    </dl>
    <dl>
      <dt>編集</dt>
      <dd>1.編集対象番号に編集したい投稿の番号を入力し、編集ボタンを押してください。</dd>
      <dd>2.編集ボタンを押すと、受信編集番号・投稿入力欄に編集対象番号で入力した番号・投稿内容が表示されます。</dd>
      <dd>3.投稿入力欄に表示された内容(名前・コメント)を編集してください。</dd>
      <dd>4.編集入力欄・投稿入力欄に入力した内容(受信編集番号・パスワード要求・名前・コメント)を確認し、送信ボタンを押してください。(パスワード要求には、編集したい投稿の新規投稿時に保存したパスワードを入力してください。)</dd>
      <dd>5.削除時入力欄下の投稿を確認し、編集した投稿の末尾に【編集済】が追加されていれば編集完了です。</dd>
    </dl>
    <h2>新規投稿・編集時入力欄</h2>
    <form action="" method="POST">
      <!-- 編集番号 -->
      <label for="edit">編集対象番号<span>※5</span>：<br /></label>
      <input id="edit" type="number" name="edit" min="1">
      <br />
      <!-- 編集ボタン -->
      <input type="submit" name="btn_edit" value="編集"><br />
      <input type="hidden" name="Emode" value="edit">
    </form>
    <form action="" method="POST">
      <!-- 受信編集番号 -->
      <label for="edit_r">受信編集番号<span>※1</span>：<br /></label>
      <input id="edit_r" type="number" name="edit_r" readonly min="1" value="<?php echo $exvalues; ?>">
      <br />
      <!-- 要求パスワード -->
      <label for="edit_password">パスワード要求<span>※2</span>：<br /></label>
      <input id="edit_password" type="password" name="edit_password" maxlength="12">
      <br />
      <br />
      <!-- 名前 -->
      <label for="name">名前<span>※3</span>：<br /></label>
      <input id="name" type="text" name="name" maxlength="12" value="<?php echo $edname; ?>">
      <br />
      <!-- コメント -->
      <label for="comment">コメント<span>※3</span>：<br /></label>
      <textarea id="comment" name="comment" maxlength="50"><?php echo $edcomment; ?></textarea><br />
      <!-- 保存時パスワード -->
      <label for="password">パスワード保存<span>※3※4</span>：<br /></label>
      <input id="password" type="password" name="password" maxlength="12">
      <br />
      <!-- 送信ボタン -->
      <input type="submit" name="btn_submit" value="送信">
    </form>
    <dl class="margin">
      <dt>削除</dt>
      <dd>1.削除対象番号に削除したい投稿の番号、パスワード要求に削除したい投稿の新規投稿時に保存したパスワードを入力してください。</dd>
      <dd>2.削除時入力欄下の投稿を確認し、【削除済】が表示されていれば削除完了です。</dd>
    </dl>
    <h2>削除時入力欄</h2>
    <!-- 削除フォーム -->
    <form action="" method="POST">
      <!-- 削除対象番号 -->
      <label for="delete">削除対象番号<span>※5</span>：<br /></label>
      <input id="delete" type="number" name="delete" min="1">
      <br />
      <!-- 要求パスワード -->
      <label for="delete_password">パスワード要求<span>※2</span>：<br /></label>
      <input id="delete_password" type="password" name="delete_password" maxlength="12">
      <br />
      <!-- 削除ボタン -->
      <input type="submit" name="btn_delete" value="削除"><br />
      <input type="hidden" name="Dmode" value="delete">
    </form>
    <!-- 入力フォーム直下にtextデータ表示 -->
    <div>
      <?php echo $line; ?>
    </div>
  </body>
</html>