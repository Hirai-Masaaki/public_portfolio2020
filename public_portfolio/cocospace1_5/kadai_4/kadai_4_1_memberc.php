<?php
require_once("kadai_4_1_db.php");
$db = db_connect();

if (!empty($_POST["name"]) && !empty($_POST["password"])) {
  $name = $_POST["name"];
  $password = $_POST["password"];
  try{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare("SELECT * FROM member WHERE name=(:name) AND flag=1");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt as $row) {
    }
    $Lname = $row["name"];
    if ($Lname == $name) {
      $message1 = null;
      $message2 = "既に入力された名前は使われています。";
    } else {
      $message1 = "入力内容を確認し、問題なければ確認ボタンを押してください。";
      $message2 = null;
    }
  }catch (PDOException $e){
    echo "Error";
    die();
  }
} else {
  $message1 = "入力欄に空欄があります。";
}

define('SMARTY_DIR', '/home/*****/public_html/kadai_4/smarty/');
define('SMARTY_TMPL_DIR', '/home/*****/public_html/kadai_4/templates/');
define('SMARTY_COMPILE_DIR', '/home/*****/public_html/kadai_4/templates_c/');

require_once(SMARTY_DIR.'Smarty.class.php');

$smarty = new Smarty();

$smarty->template_dir = SMARTY_TMPL_DIR;
$smarty->compile_dir = SMARTY_COMPILE_DIR;

$template = 'kadai_4_1_memberc.tpl';
$smarty->assign('name',$name);
$smarty->assign('password',$password);
$smarty->assign('message1',$message1);
$smarty->assign('message2',$message2);
$smarty->display($template);