<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <?php
    $fp = fopen("kadai_2.txt", "w");
    fwrite($fp, "Hello, World!");
    fclose($fp);
  ?>
</body>
</html>