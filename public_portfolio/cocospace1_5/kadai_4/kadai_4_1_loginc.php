<?php
session_start();

require_once("kadai_4_1_db.php");
$db = db_connect();

try{
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (!empty($_POST["uid"]) && !empty($_POST["password"])) {
    $uid = $_POST["uid"];
    $password = $_POST["password"];

    $stmt = $db -> prepare("SELECT * FROM member WHERE uid=(:uid) AND flag=1");
    $stmt->bindValue(':uid', $uid, PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt as $row) {
    }
    $Lpassword = $row["password"];
    if ($Lpassword == $password) {
      $Lname = $row["name"];
      $_SESSION["name"] = $Lname;
      $_SESSION["password"] = $Lpassword;
      $message3 = null;
      header("Location: kadai_4_1.php");
      exit();
    } else {
      $message3 = "入力内容が登録内容と一致していません。";
    }
    $message2 = null;
    $message3 = null;
  } else {
    $message2 = "入力欄に空欄があります。";
    $message3 = null;
  }
  $message1 = null;
}catch(PDOException $e){
  $message1 = "Error";
  die();
}

define('SMARTY_DIR', '/home/*****/public_html/kadai_4/smarty/');
define('SMARTY_TMPL_DIR', '/home/*****/public_html/kadai_4/templates/');
define('SMARTY_COMPILE_DIR', '/home/*****/public_html/kadai_4/templates_c/');

require_once(SMARTY_DIR.'Smarty.class.php');

$smarty = new Smarty();

$smarty->template_dir = SMARTY_TMPL_DIR;
$smarty->compile_dir = SMARTY_COMPILE_DIR;

$template = 'kadai_4_1_loginc.tpl';
$smarty->assign('message1',$message1);
$smarty->assign('message2',$message2);
$smarty->assign('message3',$message3);
$smarty->display($template);