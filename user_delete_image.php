<?php
session_start();
$void_flag = true;
require_once('common/db_connect.php');
$select_sql = 'SELECT id FROM workers WHERE id = :id';
$select_result = $dbh->prepare($select_sql);
$select_result->bindParam(':id', $_GET['id']);
$select_result->execute();
$fetch_result = $select_result->fetch(PDO::FETCH_ASSOC);
if ($_SESSION['id'] == $fetch_result['id']) {
	$update_sql = 'UPDATE workers SET image_name = :image_name WHERE id = :id';
	$update_result = $dbh->prepare($update_sql);
	$update_result->bindValue(':id', $_GET['id']);
	$update_result->bindValue(':image_name', null);
	$update_result->execute();
	$result_msg = '削除できました';
} else {
	$error_msg = 'お探しのページは一時的にアクセスできない状況にあるか、移動もしくは削除された可能性があります';
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
<a href="user_info.php?id=<?php echo $fetch_result['id']; ?>">マイページに戻る</a>
<?php else: ?>
<?php echo $error_msg; ?>
<a href="display.php">掲示板トップに戻る</a>
<?php endif; ?>
</body>
</html>

