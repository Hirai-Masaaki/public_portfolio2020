<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
    <form action="kadai_6.php" method="post">
        text:<br />
        <textarea name="comment" cols="30" rows="5"></textarea><br />
        <br />
        <input type="submit" value="送信する" />
        <?php
            $fp = fopen("kadai_6.txt", "a");
            fwrite($fp, $_POST["comment"] . PHP_EOL);
            fclose($fp);
        ?>
    </form>
</body>
</html>