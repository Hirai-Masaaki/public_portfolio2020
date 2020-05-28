<?php
session_start();

require_once("kadai_4_1_db.php");
$db = db_connect();

if(!empty($_GET)) {
  $token = $_GET["token"];
  try{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("SELECT token FROM member WHERE token=(:token) AND flag =1");
    $stmt->bindValue(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    foreach ($stmt as $row){}
    $mem_token = $row['token'];
    if ($token == ''){
      $message1 = "もう一度登録をやりなおして下さい。";
      $message2 = null;
      $message3 = null;
    } elseif ($mem_token == $token) {
      $message1 = null;
      $message2 = "既に登録されています。";
      $message3 = null;
    } else {
      $message1 = null;
      $message2 = null;
      $message3 = null;

      $stmt = $db->prepare("SELECT mail FROM premember WHERE token=(:token) AND flag =0 AND date > now() - interval 24 hour");
      $stmt->bindValue(':token', $token, PDO::PARAM_STR);
      $stmt->execute();
      
      $row_count = $stmt->rowCount();
      if( $row_count ==1){
        $mail_array = $stmt->fetch();
        $mail = $mail_array["mail"];
        $_SESSION['mail'] = $mail;
        $_SESSION['token'] = $token;
        $message3 = null;
      }else{
        $message3 = "このURLは利用できません。";
      }
      $db = null;
    }
  }catch (PDOException $e){
    die();
  }
}

define('SMARTY_DIR', '/home/*****/public_html/kadai_4/smarty/');
define('SMARTY_TMPL_DIR', '/home/*****/public_html/kadai_4/templates/');
define('SMARTY_COMPILE_DIR', '/home/*****/public_html/kadai_4/templates_c/');

require_once(SMARTY_DIR.'Smarty.class.php');

$smarty = new Smarty();

$smarty->template_dir = SMARTY_TMPL_DIR;
$smarty->compile_dir = SMARTY_COMPILE_DIR;

$template = 'kadai_4_1_member.tpl';
$smarty->assign('message1',$message1);
$smarty->assign('message2',$message2);
$smarty->assign('message3',$message3);
$smarty->display($template);