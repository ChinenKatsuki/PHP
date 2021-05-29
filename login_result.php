<?php
session_start();
$mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
$pass = filter_input(INPUT_POST, 'pass');
if (!empty($mail) && !empty($pass)) {
	require_once('common/db_connect.php');
	$select_sql = 'SELECT id, name FROM workers WHERE mail = :mail AND pass = :pass';
	$select_result = $dbh->prepare($select_sql);
	$select_result->bindParam(':mail', $mail);
	$select_result->bindParam(':pass', $pass);
	$select_result->execute();
	if ($select_result->rowCount() == 0) {
		$result_msg = 'メンバーが存在しません';
	} else {
		$fetch_result = $select_result->fetch(PDO::FETCH_ASSOC);
		$_SESSION['id'] = $fetch_result['id'];
		$_SESSION['name'] = $fetch_result['name'];
		header('Location: display.php');
	}
} else {
	$result_msg = 'メールアドレスもしくは、パスワードの入力に誤りがあります。';
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<?php echo $result_msg; ?><br>
<a href="login.php">ログインページに戻る</a>
</body>
</html>
