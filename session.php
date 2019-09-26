<?php
	session_start();
	if( isset( $_SESSION['username'] ) ) unset( $_SESSION['username'] );
	//else echo '初めからセッション情報はありませんでした' . "<br/>";

	//入力フォームに入力後



	$flg = false;
	if ( isset( $_POST['uid'] ) && isset( $_POST['psw'] ) ) {
		if ( ( $_POST['uid'] === 'test' ) && ( $_POST['psw'] === 'test' ) ) {
			session_regenerate_id( true );
			$_SESSION['username'] = $_POST['uid'];
			header( "Location: ./testtest.php" );
			exit( 0 );
		}
		else $flg = true;
	}

	//$_SESSION['username'] = "tanaka";
	//echo $_SESSION['username'] . "<br/>";
	//unset( $_SESSION['username'] );
	//echo $SESSION['username'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>Hello PHP</title>
	</head>
	<body>
		<form action = "session.php" method = "post">

				ID:<input type = "text" name ="uid"
					<?php
						if ( isset( $_POST['uid'] ) ){
								echo "value = \"{$_POST['uid']}\"";
						}
					?>
				><br/>
				PASS:<input type = "password" name ="psw"><br/>
				<input type = "submit" value ="ログイン">
		</form>
		<?php
		//if( isset( $_SESSION['username'] ) ) echo '田中ログイン情報あるよ';
		//else echo 'tanakaログイン情報なし';

		if( $flg === true ) echo 'ログインに失敗しました';
		 ?>
	</body>
</html>
