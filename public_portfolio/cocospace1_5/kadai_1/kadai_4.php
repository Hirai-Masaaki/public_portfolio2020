<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
    <form action="kadai_4.php" method="post">
        text:<br />
        <textarea name="comment" cols="30" rows="5"></textarea><br />
        <br />
        <input type="submit" value="送信する" />
        <td><br />text:</td><td><?php echo $_POST["comment"] ?></td>
    </form>
</body>
</html>