<?php
session_start();

$_SESSION = array();
session_destroy();

header("Location: kadai_3_1.php");
exit();