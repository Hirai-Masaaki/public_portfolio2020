<?php
session_start();

$_SESSION = array();
session_destroy();

header("Location: kadai_4_1.php");
exit();