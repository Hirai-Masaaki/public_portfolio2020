<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
    <?php $fp = fopen("kadai_1_2.txt", "w");
    fwrite($fp, "Good morning!");
    fclose($fp); ?>
</body>
</html>