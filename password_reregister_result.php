<?php
session_start();
$time = time();
$void_flag = false;
if ((isset($_SESSION['uniq'])) && ($_POST['key'] == $_SESSION['key']) && ($time - $_SESSION['time'] <= 1800)) {
	if ($_POST['new_pass'] == $_POST['new_pass_confirm']) {
		if (preg_match('/^[a-zA-Z0-9]{8,16}$/', $_POST['new_pass'])) {
			require_once('common/db_connect.php');
			$update_sql = 'UPDATE workers SET pass = :pass where mail = :mail';
			$update_result = $dbh->prepare($update_sql);
			$update_result->bindParam(':pass', $_POST['new_pass']);
			$update_result->bindParam(':mail', $_SESSION['mail']);
			$update_result->execute();
			$_SESSION = null;
			session_destroy();
			$result_msg = 'パスワード更新完了';
			$void_flag = true;
		} else {
			$error_msg = 'パスワードは半角英数字8文字以上16文字以内で入力して下さい';
		}
	} else {
		$error_msg = '入力内容にエラーがありました。もう一度入力して下さい';
	}
} else {
	$error_msg = '不正なアクセスです。再度お試しください。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<?php if ($void_flag): ?>
<?php echo $result_msg; ?><br>
<a href="login.php">ログインページに戻る</a>
<?php else: ?>
<?php echo $error_msg; ?><br>
<a href="password_reregister_form.php?key=<?php echo $_POST['url']; ?>">前のページに戻る</a>
<?php endif; ?>
</body>
</html>

