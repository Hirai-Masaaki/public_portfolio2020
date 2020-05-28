<!-- PHP -->
<?php 
session_start();

require_once("kadai_3_1_db.php");
$db = db_connect();

$table_create_query = 'CREATE TABLE member (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  uid VARCHAR(13) NOT NULL,
  name VARCHAR(12) NOT NULL,
  password VARCHAR(20) NOT NULL,
  mail VARCHAR(256) NOT NULL,
  token VARCHAR(128) NOT NULL,
  flag TINYINT(1) DEFAULT 1 NOT NULL
  )ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';
$result = $db->query($table_create_query);

$table_create_query = 'CREATE TABLE premember (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  mail VARCHAR(256) NOT NULL,
  token VARCHAR(128) NOT NULL,
  date DATETIME NOT NULL,
  flag TINYINT(1) DEFAULT 0 NOT NULL
  )ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';
$result = $db->query($table_create_query);

$table_create_query = 'CREATE TABLE post (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name varchar(12) NOT NULL,
comment varchar(50),
date DATETIME NOT NULL,
file_path varchar(255),
extension varchar(5)
)ENGINE=InnoDB DEFAULT CHARACTER SET=utf8';
$result = $db->query($table_create_query);

// $stmt = $db->prepare("DROP TABLE member");
// $stmt -> execute();
// $stmt = $db->prepare("DROP TABLE premember");
// $stmt -> execute();
// $stmt = $db->prepare("DROP TABLE post");
// $stmt -> execute();
// $stmt = $db->prepare("DELETE FROM post");
// $stmt -> execute();

try {
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (!empty($_SESSION['name'])) {
    $name = $_SESSION['name'];
    $message1 = "ようこそ、$name さん";
    $message4 = null;
    $readonly = null;

    if (empty($_POST['edit_num']) && empty($_POST['delete_num']) && empty($_POST['edit'])) {
      if (!empty($_POST['comment']) || is_uploaded_file($_FILES['upfile']['tmp_name'])){
        $comment = $_POST['comment'];
        $media_data = $_FILES['upfile']['tmp_name'];
        $stmt = $db->prepare("SELECT * FROM post ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        foreach($stmt as $row) {}
        $max_num = $row['id'];
        $post_num = $max_num + 1;
        $path = "/home/vagrant/php/upfile/$post_num";
        if (mkdir($path)){
          if (move_uploaded_file($media_data, $path . '/' . $_FILES['upfile']['name'])) {
            $media_name = $_FILES['upfile']['name'];
            $file_path = "./upfile/$post_num/" . $media_name;
            $extension = substr($media_name, strrpos($media_name, '.') + 1);
            switch ($extension){
              case 'jpg' :
              case 'jpeg' :
              case 'JPG' :
              case 'JPEG' :
                $extension = 'jpeg';
                break;
              case 'png' :
              case 'PNG' :
                $extension = 'png';
                break;
              case 'gif' :
              case 'GIF' :
                $extension = 'gif';
                break;
              case 'mp4' :
              case 'MP4' :
                $extension = 'mp4';
                break;
              case 'avi' :
              case 'AVI' :
                $extension = 'avi';
                break;
              case 'mov' :
              case 'MOV' :
                $extension = 'mov';
                break;
              default :
                $media_data = null;
                $media_name = null;
                $extension = null;
                $message5 = '非対応ファイルです。';
            }
          } else {
            $media_data = null;
            $media_name = null;
            $extension = null;
            $message5 = null;
          }
          $message7 = null;
        } else {
          $message7 = 'ファイルアップロードに失敗しました。';
        }

        $stmt = $db->prepare("INSERT INTO post (name,comment,date,file_path,extension) VALUES (:name,:comment,now(),:file_path,:extension)");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindValue(':file_path', $file_path, PDO::PARAM_STR);
        $stmt->bindValue(':extension', $extension, PDO::PARAM_STR);
        $stmt->execute();
        $message6 = null;
      } else {
        $message5 = null;
        if ($_POST) {
          $message6 = "必要なフォームに入力して下さい。";
        } else {
          $message6 = null;
        }
      }
    } else {
      $message5 = null;
      $message6 = null;
      $message7 = null;
    }

    if (!empty($_POST["delete_num"])) {
      $delete_num = $_POST["delete_num"];
      $stmt = $db->prepare("SELECT * FROM post WHERE id=(:id)");
      $stmt->bindValue(':id', $delete_num, PDO::PARAM_INT);
      $stmt->execute();
      foreach($stmt as $row) {}
      if ($row['name'] == $name && $row['id'] == $delete_num) {
        $null = null;
        $delete_ok = "【削除済】";
        $stmt = $db->prepare("UPDATE post SET name = :name, comment = :comment, date = now(), file_path = :file_path, extension = :extension WHERE id = :id");
        $stmt->bindValue(':name', $null, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $delete_ok, PDO::PARAM_STR);
        $stmt->bindValue(':file_path', $null, PDO::PARAM_STR);
        $stmt->bindValue(':extension', $null, PDO::PARAM_STR);
        $stmt->bindValue(':id', $delete_num, PDO::PARAM_INT);
        $stmt->execute();
        $path = "/home/vagrant/php/upfile/$delete_num";
        $dir = glob("$path/*");
        foreach ($dir as $file){
          unlink($file);
        }
        $message3 = "$delete_num 番の投稿を削除しました。";
      } else {
        $message3 = "他のユーザーの投稿、存在しない投稿、または削除済みの投稿です。";
      }
    } else {
      $message3 = null;
    }

    if (!empty($_POST["edit"])) {
      $edit = $_POST["edit"];
      $stmt = $db->prepare("SELECT * FROM post WHERE id=(:id)");
      $stmt->bindValue(':id', $edit, PDO::PARAM_INT);
      $stmt->execute();
      foreach($stmt as $row) {}
      if ($row['name'] == $name && $row['id'] == $edit) {
        $edit = $row['id'];
        $edit_comment = $row['comment'];
        $message2 = "$edit 番を編集しています。";
      } else {
        $edit = null;
        $edit_comment = null;
        $message2 = "他のユーザーの投稿、存在しない投稿、または削除済みの投稿です。";
      }
    } else {
      $edit = null;
      $edit_comment = null;
      $message2 = null;
    }

    if (!empty($_POST['edit_num'])) {
      $edit_num = $_POST['edit_num'];
      $comment = $_POST['comment'];
      $path = "/home/vagrant/php/upfile/$edit_num";
      $dir = glob("$path/*");
      foreach ($dir as $file){
        unlink($file);
      }
      if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
        $media_data = $_FILES['upfile']['tmp_name'];
        if (move_uploaded_file($media_data, $path . '/' . $_FILES['upfile']['name'])) {
          $media_name = $_FILES['upfile']['name'];
          $file_path = "./upfile/$edit_num/" . $media_name;
          $extension = substr($media_name, strrpos($media_name, '.') + 1);
          switch ($extension){
            case 'jpg' :
            case 'jpeg' :
            case 'JPG' :
            case 'JPEG' :
              $extension = 'jpeg';
              break;
            case 'png' :
            case 'PNG' :
              $extension = 'png';
              break;
            case 'gif' :
            case 'GIF' :
              $extension = 'gif';
              break;
            case 'mp4' :
            case 'MP4' :
              $extension = 'mp4';
              break;
            case 'avi' :
            case 'AVI' :
              $extension = 'avi';
              break;
            case 'mov' :
            case 'MOV' :
              $extension = 'mov';
              break;
            default :
              $media_data = null;
              $media_name = null;
              $extension = null;
              $message5 = '非対応ファイルです。';
          }
        } else {
          $media_data = null;
          $media_name = null;
          $extension = null;
          $message5 = null;
        }
      }
      $stmt = $db->prepare("UPDATE post SET comment = :comment, date = now(), file_path = :file_path, extension = :extension WHERE id = :id");
      $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
      $stmt->bindValue(':file_path', $file_path, PDO::PARAM_STR);
      $stmt->bindValue(':extension', $extension, PDO::PARAM_STR);
      $stmt->bindValue(':id', $edit_num, PDO::PARAM_INT);
      $stmt->execute();
    } else {
      $edit_num = null;
      $message5 = null;
      $message7 = null;
    }
  } else {
    $message1 = "掲示板を利用するにはアカウントが必要です。→";
    $message4 = "掲示板を利用するにはアカウントが必要です。";
    $message3 = null;
    $message2 = null;
    $message5 = null;
    $message6 = null;
    $message7 = null;
    $edit = null;
    $edit_comment = null;
    $readonly = 'readonly';
  }
  $stmt = $db->prepare("SELECT * FROM post ORDER BY id DESC");
  $stmt->execute();
  $db = null;
    
  } catch(PDOException $e) {
    echo "error";
    exit();
  }
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="kadai_3_1.css">
    <link rel=”icon” href=“favicon.ico”>
    <title>-簡易掲示板-</title>
    <style>
      <?php if(!empty($name)) { ?>
        header nav button {
          display: none;
        }
        header li + li +li button {
          display: block; 
        }
        header nav ul + ul li {
          float: left;
        }
      <?php } else {?>
        header li + li +li button {
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
          <li><a href="#">TOP</a></li>
          <li><a href="#link1">掲示板</a></li>
        </ul>
        <ul>
          <li><button><a href="kadai_3_1_login.php">ログイン</a></button></li>
          <li><button><a href="kadai_3_1_mail.php">会員登録</a></button></li>
          <li><button><a href="kadai_3_1_logout.php">ログアウト</a></button></li>
        </ul>
        <ul class="message1">
          <li><?= $message1 ?></li>
        </ul>
      </nav>
    </header>
    <div>
      <main>
        <section>
          <h3 id="link1">-投稿一覧-</h3>
          <div class="post">
            <?php foreach ($stmt as $row) : ?>
              <p><?= $row['id'], " ", $row['name'], " ", $row['comment'], " ", $row['date'] ?></p>
              <?php if($row['extension'] == "jpeg" || $row['extension'] == "png" || $row['extension'] == "gif") : ?>
                <div class="media"><img src="<?= $row['file_path'] ?>" width="100px" height="80px"></div>
              <?php elseif($row['extension'] == "mp4" || $row['extension'] == "avi" || $row['extension'] == "mov") : ?>
                <div class="media"><video src="<?= $row['file_path'] ?>" width="280px" height="200px" controls></video></div>
              <?php endif ?>
            <?php endforeach ?>
          </div>
        </section>
        <section class="margin-bottom">
          <h3>-入力フォーム-<span class="message"><?= $message2 . $message3 . $message4 . $message5 . $message6 . $message7 ?></span></h3>
          <div class="boxes">
            <div class="box1">
              <form action="" method="POST" enctype="multipart/form-data">
                <!-- 受信編集番号 -->
                <input id="edit_num" type="hidden" readonly name="edit_num" min="1" value="<?= $edit ?>">
                <h4>新規投稿</h4>
                <!-- コメント -->
                <input id="comment" typr="text" name="comment" <?= $readonly ?> maxlength="50" placeholder="※Enterで送信可。50文字まで" value="<?= $edit_comment ?>"><br />
                <p class="notes">※投稿可能なファイルは8.3MBまでです。</p>
                <!-- ファイル -->
                <input type="file" name="upfile" accept="image/*,video/*"><br />
                <!-- 送信ボタン -->
                <input type="submit" name="btn_submit" value="送信">
              </form>
            </div>
            <div class="box2">
              <h4>投稿編集</h4>
              <form action="" method="POST">
                <!-- 編集番号 -->
                <input id="edit" type="number" name="edit" <?= $readonly ?> min="1" placeholder="編集する投稿番号">
                <br />
                <!-- 編集ボタン -->
                <input type="submit" name="btn_edit" value="編集内容送信"><br />
                <input type="hidden" name="Emode" value="edit">
              </form>
            </div>
            <div class="box3">
              <h4>投稿削除</h4>
              <!-- 削除フォーム -->
              <form action="" method="POST">
                <!-- 削除対象番号 -->
                <input id="delete_num" type="number" name="delete_num" <?= $readonly ?> min="1" placeholder="削除する投稿番号">
                <br />
                <!-- 削除ボタン -->
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