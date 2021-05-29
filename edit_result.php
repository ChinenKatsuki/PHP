<?php
session_start();
$void_flag = '';
if (!empty($title) && mb_strlen($title) <= 15) {
	if (!empty($text) && mb_strlen($text) <= 140 ) {
		$title = $_POST['title'];
		$text = $_POST['text'];
		$id = $_POST['id'];
		require_once('common/db_connect.php');
		$select_sql = 'SELECT worker_posts.worker_id FROM workers INNER JOIN worker_posts ON worker_posts.worker_id = workers.id WHERE worker_posts.id = :id';
		$select_result = $dbh->prepare($select_sql);
		$select_result->bindParam(':id', $id);
		$select_result->execute();
		$fetch_result = $select_result->fetch(PDO::FETCH_ASSOC);
		$void_flag = true;
		if ($_SESSION['id'] == $fetch_result['worker_id']) {
			$update_sql = 'UPDATE worker_posts SET title = :title, text = :text WHERE id = :id';
			$update_result = $dbh->prepare($update_sql);
			$update_result->bindParam(':title', $title);
			$update_result->bindParam(':text', $text);
			$update_result->bindParam(':id', $id);
			$update_result->execute();
			$result_msg = '編集できました';
		} else {
			$result_msg = 'お探しのページは一時的にアクセスできない状況にあるか、移動もしくは削除された可能性があります。';
		}
	} else {
		$error_msg = '本文は140文字以内で入力して下さい';
	}
} else {
	$error_msg = 'タイトルは15文字以内で入力して下さい';
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
<a href="display.php">掲示板トップページに戻る</a>
<?php else: ?>
<?php echo $error_msg; ?><br>
<a href="edit.php?id=<?php echo $id; ?>">編集画面に戻る</a>
<?php endif; ?>
</body>
</html>
