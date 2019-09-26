<?php 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>Hello DataBase</title>
	</head>
	<body>
		<form action = "db.php" method = "post">
    		名前:<input type = "text" name ="name"><br/>
    		年齢:<input type = "text" name ="age"><br/>
    		<input type = "submit" value ="登録">
		</form>
		<?php
			if( isset($_POST['name']) && isset($_POST['age'] ) ) {
				if( !(strlen($_POST['name']) === 0) && !(strlen($_POST['age']) === 0) ){
				
				$link = mysqli_connect("localhost:3306", "root", "", "studyphp");
				
				if( !mysqli_connect_errno() ){
					mysqli_set_charset( $link, 'utf8'); //文字コード指定
					$name = mysqli_real_escape_string($link, $_POST['name']);
					$age = mysqli_real_escape_string($link, $_POST['age']);
					$sql = "INSERT INTO human (name, age) VALUES ( \"{$name}\", $age )";
					$result = mysqli_query($link, $sql); //クエリの実行

					if( !$result ) echo 'うまくできんかったで～';
					else{
						$sql = "SELECT * FROM human";
						$result = mysqli_query($link, $sql); //クエリの実行
						if(!$result) echo '結果は取得できませんでした';
						else {
							echo "<table border=\"1\">";
							
							foreach( mysqli_fetch_all($result) as $data ){
								//var_dump($data);
								echo "<tr>";
								echo "<td>" . $data[0] . "</td>";
								echo "<td>" . $data[1] . "</td>";
								echo "</tr>";
							}
							echo "</table>";
							echo "<br/>";
							mysqli_close($link);
							}
						}	
					}
				}
			}else echo '繋がりませんでした';
		?>
	</body>
</html>
