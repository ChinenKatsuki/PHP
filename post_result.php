<?php
session_start();
$title = $_POST['title'];
$text = $_POST['text'];
if(!empty($title) && mb_strlen($title) <= 15) {
	if (!empty($text) && mb_strlen($text) <= 140) {
		require_once('common/db_connect.php');
		$title = $_POST['title'];
		$text = $_POST['text'];
		$sql_insert = 'INSERT INTO worker_posts (title, text, worker_id) VALUES (:title, :text, :worker_id)';
		$result_insert = $dbh->prepare($sql_insert);
		$result_insert->bindParam(':title', $title);
		$result_insert->bindParam(':text', $text);
		$result_insert->bindParam(':worker_id', $_SESSION['id']);
		$result_insert->execute();
		$result_msg = '投稿しました。';
		$result_fetch = $result_insert->fetch();
		$_SESSION['title'] = $result_fetch['title'];
		$_SESSION['text'] = $result_fetch['text'];
		$void_flag = true;
	} else {
		$error_msg = '本文は140文字以内で入力して下さい。';
	}
} else {
	$error_msg = 'タイトルは15文字以内で入力して下さい。';
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
<a href="display.php">投稿をみる</a>
<?php else: ?>
<?php echo $error_msg; ?><br>
<a href="post.php">前の画面に戻る</a>
<?php endif; ?>
</body>
</html>
