<?php
	session_start();

	if ( !isset( $_SESSION['id'] ) ) {
		header('Location: ./login.php');
		exit( 0 );
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<title>あなたのページ</title>
</head>
<body>
	<?php
		if( $_SESSION['before'] === 'account' ) echo 'アカウント登録が完了しました' . "<br/>";
		if( $_SESSION['before'] === 'login' ) echo 'ログインに成功しました' . "<br/>";
		output_userdata();
	?>

	<?php
		function output_userdata(){
			echo 'ようこそ' . $_SESSION['id'] . 'さん' . "<br/>";
			echo 'ここはあなたのページです' . "<br/>";
			echo "<h1>あなたのユーザー情報について</h1>";

			echo 'ID:' . $_SESSION['id'] . "<br/>";
			echo 'パスワード:' . $_SESSION['psw'] . "<br/>";
			echo '年齢:' . $_SESSION['age'] . "<br/>";
			echo '性別:' . get_gender( $_SESSION['gender'] ) . "<br/>";
		}

		function get_gender( $data ){
			if( $data === '1' ) return '男';
			else if( $data === '0' ) return '女';
			else return '性別のデータにおいてエラーが発生しています';
		}
	?>
</body>
</html>
