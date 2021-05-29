<?php
session_start();
require_once('common/db_connect.php');
$select_sql = 'SELECT worker_posts.worker_id, worker_posts.delete_text FROM workers INNER JOIN worker_posts ON worker_posts.worker_id = workers.id WHERE worker_posts.id = :id';
$select_result = $dbh->prepare($select_sql);
$select_result->bindParam(':id', $_GET['id']);
$select_result->execute();
$fetch_result = $select_result->fetch(PDO::FETCH_ASSOC);
if ($_SESSION['id'] == $fetch_result['worker_id']) {
	$delete_sql = 'UPDATE worker_posts SET delete_text = 1 WHERE id = :id';
	$delete_result = $dbh->prepare($delete_sql);
	$delete_result->bindParam(':id', $_GET['id']);
	$delete_result->execute();
	$result_msg = '削除しました';
} else {
	$result_msg = 'お探しのページは一時的にアクセスできない状況にあるか、移動もしくは削除された可能性があります。';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<?php echo $result_msg; ?><br>
<a href="display.php">掲示板トップページに戻る</a>
</body>
</html>

