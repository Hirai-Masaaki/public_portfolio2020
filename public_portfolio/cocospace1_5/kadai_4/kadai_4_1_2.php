<?php 
ini_set('display_errors', 0);
session_start();

define('SMARTY_DIR', '/home/*****/public_html/kadai_4/smarty/');
define('SMARTY_TMPL_DIR', '/home/*****/public_html/kadai_4/templates/');
define('SMARTY_COMPILE_DIR', '/home/*****/public_html/kadai_4/templates_c/');
define('SMARTY_CACHE_DIR', '/home/*****/public_html/kadai_4/cache/');

require_once(SMARTY_DIR.'Smarty.class.php');

$smarty = new Smarty();

$smarty->template_dir = SMARTY_TMPL_DIR;
$smarty->compile_dir = SMARTY_COMPILE_DIR;
$smarty->cache_dir = SMARTY_CACHE_DIR;
$smarty->caching = 1;
$smarty->compile_check = false;
$smarty->cache_lifetime = 10;

$template = 'kadai_4_1.tpl';
$cacheId = "cached!";
if (!$smarty->isCached($template, $cacheId)) {
echo 'キャッシュなし';

require_once("kadai_4_1_db.php");
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
        $path = __DIR__ . "/upfile/$post_num";
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
        $path = __DIR__ . "/upfile/$delete_num";
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
      $path = __DIR__ . "/upfile/$edit_num";
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
    $message1 = null;
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

if (preg_match('/^(?=.*Mac)(?=.*OS)(?=.*iPhone)|^(?=.*Mac)(?=.*OS)(?=.*iPad)|^(?=.*Mac)(?=.*OS)(?=.*iPod)|Android/', $_SERVER['HTTP_USER_AGENT'])) {
  $agent_smart = 'スマホ：'.$_SERVER['HTTP_USER_AGENT'];
  $agent_pc = null;
  $agent_future = null;
} elseif (preg_match('/DoCoMo|KDDI|SoftBank|J-PHONE|WILLCOM|emobile/', $_SERVER['HTTP_USER_AGENT'])) {
  $agent_smart = null;
  $agent_pc = null;
  $agent_future = 'ケータイ：'.$_SERVER['HTTP_USER_AGENT'];
} elseif (preg_match('/Windows|^(?=.*Mac)(?=.*OS)/', $_SERVER['HTTP_USER_AGENT'])) {
  $agent_smart = null;
  $agent_pc = 'PC：'.$_SERVER['HTTP_USER_AGENT'];
  $agent_future = null;
} else {
  $agent_smart = null;
  $agent_pc = null;
  $agent_future = null;
}

$smarty->assign('name',$name);
$smarty->assign('message1',$message1);
$smarty->assign('stmt',$stmt);
$smarty->assign('file_path',$file_path);
$smarty->assign('message2',$message2);
$smarty->assign('message3',$message3);
$smarty->assign('message4',$message4);
$smarty->assign('message5',$message5);
$smarty->assign('message6',$message6);
$smarty->assign('message7',$message7);
$smarty->assign('edit',$edit);
$smarty->assign('readonly',$readonly);
$smarty->assign('edit_comment',$edit_comment);
$smarty->assign('agent_smart',$agent_smart);
$smarty->assign('agent_pc',$agent_pc);
$smarty->assign('agent_future',$agent_future);
}
echo "<br />ないがないなら、あるよ";
$smarty->display($template, $cacheId);

// if (empty($_POST['edit_num']) && empty($_POST['delete_num']) && empty($_POST['edit'])) {
//   if (!empty($_POST['comment']) || is_uploaded_file($_FILES['upfile']['tmp_name'])){
//     $smarty->cache_lifetime = 0;
//     echo '削除';
//   }
// }
// if (!empty($_POST["delete_num"])){
//   if ($row['name'] == $name && $row['id'] == $delete_num) {
//     $smarty->cache_lifetime = 0;
//     echo '削除';
//   }
// }
// if (!empty($_POST['edit_num'])) {
//   $smarty->cache_lifetime = 0;
//   echo '削除';
// }
// $template = 'kadai_4_1.tpl';
// if ($smarty->isCached($template)) {
//   echo '読み込み';
// } else {
//   echo '生成';
// }
// $smarty->assign('name',$name);
// $smarty->assign('message1',$message1);
// $smarty->assign('stmt',$stmt);
// $smarty->assign('file_path',$file_path);
// $smarty->assign('message2',$message2);
// $smarty->assign('message3',$message3);
// $smarty->assign('message4',$message4);
// $smarty->assign('message5',$message5);
// $smarty->assign('message6',$message6);
// $smarty->assign('message7',$message7);
// $smarty->assign('edit',$edit);
// $smarty->assign('readonly',$readonly);
// $smarty->assign('edit_comment',$edit_comment);
// $smarty->assign('agent_smart',$agent_smart);
// $smarty->assign('agent_pc',$agent_pc);
// $smarty->assign('agent_future',$agent_future);
// $smarty->display($template);