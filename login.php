<?php
		$flg = false;
		if ( isset( $_POST['id'] ) && isset( $_POST['psw'] ) ) {		//POSTの中に値が入っているか確認
			if( !(strlen($_POST['id']) === 0) && !(strlen($_POST['psw']) === 0) ){		//POSTの中に
				
				$link = mysqli_connect("localhost:3306", "root", "", "studyphp");		//データベース接続

				if( !mysqli_connect_errno() ){		//データベース接続に成功した場合
					mysqli_set_charset( $link, 'utf8'); //文字コード指定

					$id = mysqli_real_escape_string($link, $_POST['id']);		//与えられたPOSTのデータをSTRINGに変換	
					$psw = mysqli_real_escape_string($link, $_POST['psw']);		//与えられたPOSTのデータをSTRINGに変換

					$sql = "SELECT * FROM human WHERE id = \"{$id}\" AND password = \"{$psw}\"";		//sql文の作成

					$result = mysqli_query($link, $sql);		//クエリの実行

					if( $result ) {		//クエリの実行に成功していた場合

						if( get_rows( $result ) === 0 ) echo 'ログインに失敗しました' . "<br/>";		//idまたはパスワードが間違っていた場合の処理

						$data = mysqli_fetch_all($result);		//クエリの返り値を連想配列に変換
						//var_dump($data);		//出力

						//if ( ( $_POST['id'] === $data[0][1] ) && ( $_POST['psw'] === $data[0][2] ) ) {		//入力された値と検索結果を比較
							session_start();
							if( isset( $_SESSION['username'] ) ) unset( $_SESSION['username'] );

							session_regenerate_id( true );
							$_SESSION['id'] = $data[0][1];
							$_SESSION['psw'] = $data[0][2];
							$_SESSION['age'] = $data[0][3];
							$_SESSION['gender'] = $data[0][4];

							$_SESSION['before'] = 'login';

							header( "Location: ./mypage.php" );
							exit( 0 );
						//}
						//else $flg = true;
					}else echo 'エラーが発生しました';		//クエリの実行に失敗している

					mysqli_close($link);		//データベースの切断
				}
			}
		}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>login_page</title>
	</head>
	<body>
		<form action = "login.php" method = "post">
    		ID:<input type = "text" name ="id"><br/>
    		PASS:<input type = "password" name ="psw"><br/>
    		<input type = "submit" value ="ログイン">
		</form>
		<input type = "button" onclick = "location.href = 'account.php'" value = "新規登録するお"><br/>
		<?php
			if( $flg === true ) echo 'ログインに失敗しました';
		?>

		<?php
			/**
			 * 引数:クエリの実行結果
			 * 出力:その件数
			 */
			function get_rows( $data ){
				return mysqli_num_rows( $data );
			}

			/**
			 * 引数:男女どちらかの文字列
			 * 出力:データベース用にbooleanに変換
			 */
			function chgData( $gender ){
				if( $data === '男' ) return 1;
				else if( $data === '女' ) return 0;
				else return '性別のデータにおいてエラーが発生しています';
			}
		?>
	</body>
</html>
