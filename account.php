<?php 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "utf-8">
		<title>新規登録</title>
	</head>
	<body>
		<h1>新規登録</h1>
		<form action = "account.php" method = "post">
    		ID:<input type = "text" name ="id"><br/>
    		パスワード:<input type = "text" name ="pass"><br/>
    		年齢:<input type = "text" name ="age"><br/>
    		性別:<input type = "text" name ="gender"><br/>
    		<input type = "submit" value ="登録">
		</form>
		<?php
			if( isData('id') && isData('pass') && isData('age') && isData('gender') ) {		//全ての項目においてデータがあるか確認
				if( hasData('id') && hasData('pass') && hasData('age') && hasData('gender') ){		//データが格納されているか確認
				
					$link = mysqli_connect("localhost:3306", "root", "", "studyphp");		//データベースに接続
				
					if( !mysqli_connect_errno() ){		//データベースに接続できた場合
						//echo 'データベースの接続に成功しました';
						mysqli_set_charset( $link, 'utf8'); //文字コード指定

						$id = mysqli_real_escape_string($link, $_POST['id']);		//与えられたPOSTのデータをSTRINGに変換	
						$tmp = "SELECT * FROM human WHERE id = \"{$id}\"";		//入力されたidが存在しているか確認するためのsql文作成

						$result = mysqli_query($link, $tmp); //クエリの実行
						
						if( $result ) {		//クエリの実行に成功していた場合
							$num = get_rows( $result );		//件数のカウント

							if( get_rows( $result ) > 0 ){		
								echo '入力されたユーザーIDは既に存在しています' . "<br/>";
							}else{		//0件だった場合
								$pass = mysqli_real_escape_string($link, $_POST['pass']);
								$age = mysqli_real_escape_string($link, $_POST['age']);
								$gender = mysqli_real_escape_string($link, chgData( $_POST['gender'] ) );

								$sql = "INSERT INTO human (id, password, age, gender) VALUES ( \"{$id}\", \"{$pass}\", $age, \"{$gender}\" )";

								$result = mysqli_query($link, $sql); //クエリの実行

								if( $result ){ 
									$data = mysqli_fetch_all($result);		//クエリの返り値を連想配列に変換

									session_start();

									if( isset( $_SESSION['username'] ) ) unset( $_SESSION['username'] );

									session_regenerate_id( true );
									$_SESSION['id'] = $data[0][1];
									$_SESSION['psw'] = $data[0][2];
									$_SESSION['age'] = $data[0][3];
									$_SESSION['gender'] = $data[0][4];

									$_SESSION['before'] = 'account';
									mysqli_close($link);
									header( "Location: ./mypage.php" );
									exit( 0 );
								}
							}
						}
						mysqli_close($link);
					}			
				}
			}
		?>

		<?php
			
		?>

		<?php
			/**
			 * 引数:クエリの実行結果
			 * 出力:その件数
			 */
			function get_rows( $data ){
				return mysqli_num_rows( $data );
			}

			function isData( $data ){
				//echo 'key:' . $data . "<br/>";
				if( isset($_POST["{$data}"]) ) return true;
				else return false;
			}

			function hasData( $data ){
				//echo 'key:' . $data . "<br/>";
				if( !(strlen($_POST["{$data}"]) === 0) ) return true;
				else return false;
			}
		?>

		<?php
			function chgData( $gender ){
				if( $gender === '男' ) return 1;
				else if( $gender === '女' ) return 0;
				else return '性別のデータにおいてエラーが発生しています';
			}

			function getGender( $data ){
				if( $data === 1 ) return '男';
				else if( $data === 0 ) return '女';
				else return '性別のデータにおいてエラーが発生しています';
			}
		?>
	</body>
</html>