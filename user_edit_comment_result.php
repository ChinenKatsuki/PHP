<?php
session_start();
$text = $_POST['text'];
$void_flag = true;
if (mb_strlen($text) <= 100) {
	require_once('common/db_connect.php');
	$select_sql = 'SELECT id FROM workers WHERE id = :id';
	$select_result = $dbh->prepare($select_sql);
	$select_result->bindParam(':id', $_POST['id']);
	$select_result->execute();
	$fetch_result = $select_result->fetch(PDO::FETCH_ASSOC);
	if ($_SESSION['id'] == $fetch_result['id']) {
		$update_sql = 'UPDATE workers SET text = :text WHERE id = :id';
		$update_result = $dbh->prepare($update_sql);
		$update_result->bindParam(':text', $text);
		$update_result->bindParam(':id', $fetch_result['id']);
		$update_result->execute();
		$result_msg = '更新できました';
	} else {
		$result_msg = 'お探しのページは一時的にアクセスできない状況にあるか、移動もしくは削除された可能性があります。';
	}
} else {
	$error_msg = 'コメントは100文字以内で入力して下さい';
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
<?php echo $result_msg; ?><br>
<a href="user_info.php?id=<?php echo $_SESSION['id']; ?>">マイページに戻る</a>
<?php else: ?>
<?php echo $error_msg; ?><br>
<a href="user_edit_comment.php?id=<?php echo $_SESSION['id']; ?>">前のページに戻る</a>
<?php endif; ?>
</body>
</html>



