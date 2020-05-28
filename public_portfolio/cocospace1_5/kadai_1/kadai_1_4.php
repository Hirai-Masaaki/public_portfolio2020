<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
    <form action="kadai_1_4.php" method="post">
        送信データ:<br />
        <textarea name="comment" cols="30" rows="5"></textarea><br />
        <br />
        <input type="submit" value="送信する" /><br />
        受信データ:<br />
        <?php echo $_POST["comment"]; ?>
    </form>
</body>
</html>