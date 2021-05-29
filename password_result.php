<?php
session_start();
$mail = $_POST['mail'];
$void_flag = true;
if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
	require_once('common/db_connect.php');
	$select_sql = 'SELECT mail FROM workers WHERE mail = :mail';
	$select_result = $dbh->prepare($select_sql);
	$select_result->bindParam(':mail', $mail);
	$select_result->execute();
	$fetch_result = $select_result->fetch(PDO::FETCH_ASSOC);
	if ($fetch_result['mail']) {
		mb_language("japanese");
		mb_internal_encoding("utf-8");
		$time = time();
		$uniq = sha1(uniqid(mt_rand(), true));
		$to = $mail;
		$title = 'パスワード再発行のお知らせ';
		$content = '下記よりパスワードの再登録を行って下さい' . "\r\n" . "kadai19/password_reregister_form.php?key=$uniq" . "\r\n" . '上記パスワード再発行URLの使用期限は30分以内となっております';
		$headers = 'From:from@example.com';
		mb_send_mail($to, $title, $content, $headers);
		$_SESSION['time'] = $time;
		$_SESSION['mail'] = $mail;
		$_SESSION['key'] = $uniq;
	}
	$result_msg= '再発行用URLを送信しました';
} else {
	$error_msg = 'メールアドレスの形式が正しくありません';
	$void_flag = false;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<?php if ($void_flag): ?>
<?php echo $result_msg; ?>
<?php else: ?>
<?php echo $error_msg; ?><br>
<a href="password_form.php">前のページに戻る</a>
<?php endif; ?>
</body>
</html>
