<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
    <?php
    $fp = fopen("kadai_1_2.txt", "r");
    $line = fgets($fp);
    echo "$line<br>";
    fclose($fp); 
    ?>
</body>
</html>