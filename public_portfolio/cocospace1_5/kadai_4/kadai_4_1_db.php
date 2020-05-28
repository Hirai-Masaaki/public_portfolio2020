<?php
function db_connect() {
  ini_set('display_errors', 0);
  $dsn = 'mysql:host=localhost;dbname=*****;charset=utf8';
  $user = '*****';
  $password = '*****';

  try {
    $db = new PDO($dsn, $user, $password);
		return $db;
  } catch (PDOException $e) {
    die();
  }
}
