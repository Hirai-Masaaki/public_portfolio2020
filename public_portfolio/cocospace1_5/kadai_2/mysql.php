<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<?php
		// mysqlのデータベースに接続("ホスト名","ユーザー名","パスワード","データベース名")
		$mysqli = mysqli_connect("localhost","*****","*****","*****");
		// 接続できたら'接続成功'表示、できなかったら'接続失敗'表示
		if ($mysqli == null) {
			print_r('接続失敗<br />').PHP_EOL;
		} else {
			print_r('接続成功<br />').PHP_EOL;
		}
		// CREATE TABLE テーブル名
		$table_create_query = "CREATE TABLE sampletable(".
		//テーブルの設定
		"id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,".
		"name VARCHAR(10) NOT NULL".
		")DEFAULT CHARACTER SET=utf8;";
		// テーブル作成
		$result = $mysqli->query($table_create_query);

		// テーブル一覧表示
		try{
			// ("データベース名","ユーザー名","パスワード")
			$pdo = new PDO("mysql:dbname=*****;host=localhost;charset=utf8",'*****','*****');
			// テーブル名取得
			$stmt = $pdo->query('SHOW TABLES');
			while($re = $stmt->fetch(PDO::FETCH_ASSOC)){
				var_dump($re);
			}
		}catch(PDOException $e){
			var_dump($e);
		}	

		// テーブルにデータを追加
		// $table_insert_query = "INSERT INTO member(id, name) VALUES(?, ?)";
		// $stmt = $mysqli->prepare($table_insert_query);
		// if($stmt){
		// $id = '';
		// $name = 'inu';
		// $stmt->bind_param('is', $id, $name);
		// $stmt->execute();
		// 	$id = '';
		// 	$name = 'neko';
		// 	$stmt->bind_param('is', $id, $name);
		// 	$stmt->execute();
		// }

		// テーブルからデータを取得
		$table_get_query = "SELECT * FROM member";
		$result = $mysqli->query($table_get_query);
		if ($result){
			while ($data = mysqli_fetch_array($result)){
				echo '<br />'.$data['id'].' : '.$data['name'].'';
			}
		}

		// // テーブルデータを編集
		// // try {
		// // 	$sql = "UPDATE sampletable SET name = 'kujira' WHERE id = 1";
		// // 	$res = $mysqli->query($sql);
		// // } catch(PDOException $e) {
		// // 	echo $e->getMessage();
		// // 	die();
		// // }
		// try {
		// 	$sql = "DELETE FROM sampletable WHERE id = 8";
		// 	$stmt = $mysqli->query($sql);
		// } catch(PDOException $e) {
		// 	echo $e->getMessage();
		// 	die();
		// 	$mysqli = null;
		// }
		?>
	</body>
</html>