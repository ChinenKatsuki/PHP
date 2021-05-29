<?php
session_start();
$name = $_POST['name'];
$mail = $_POST['mail'];
$pass = $_POST['pass'];
$void_flag = false;
if (!empty($name) && mb_strlen($name) <= 20) {
	if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		if (preg_match('/^[a-zA-Z0-9]{8,16}$/', $pass)) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				require_once('common/db_connect.php');
				$select_sql = 'SELECT mail FROM workers WHERE mail = :mail';
				$select_result = $dbh->prepare($select_sql);
				$select_result->bindParam(':mail', $mail);
				$select_result->execute();
				if ($select_result->rowCount() == true) {
					$error_msg = 'こちらのメールアドレスは既に使われています。';
				} else {
					$insert_sql ='INSERT INTO workers (name, mail, pass) VALUES (:name, :mail, :pass)';
					$insert_result = $dbh->prepare($insert_sql);
					$insert_result->bindValue(':name', $name);
					$insert_result->bindValue(':mail', $mail);
					$insert_result->bindValue(':pass', $pass);
					$insert_result->execute();
					$register_fin = '登録ができました';
					$void_flag = true;
				}
			}
		} else {
			$error_msg = 'パスワードは半角英数かつ8以上16文字以内で登録して下さい。';
		}
	} else {
		$error_msg = 'メールアドレスの形式が正しくない。もしくは未入力です';
	}
} else {
	$error_msg = '名前は20文字以内で入力して下さい';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<?php if ($void_flag): ?>
<?php echo $register_fin; ?><br>
<a href="login.php">ログイン画面に戻る</a>
<?php else: ?>
<?php echo $error_msg; ?><br>
<a href="register.php">前の画面に戻る</a>
<?php endif; ?>
</body>
</html>
