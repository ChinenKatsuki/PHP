<?php
session_start();
require_once('common/db_connect.php');
$select_sql = 'SELECT worker_posts.id, workers.name, worker_posts.title, worker_posts.text, worker_posts.uptime, worker_posts.worker_id, worker_posts.delete_text FROM workers INNER JOIN worker_posts ON worker_posts.worker_id = workers.id WHERE worker_posts.id = :id';
$select_result = $dbh->prepare($select_sql);
$select_result->bindParam(':id', $_GET['id']);
$select_result->execute();
$fetch_result = $select_result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<?php if ($_SESSION['id'] == $fetch_result['worker_id']): ?>
<a>編集者名</a><br>
<form action="edit_result.php" method="post">
<?php echo $fetch_result['name']; ?><br>
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
<a>タイトル(15文字)</a><br>
<input type="text" name="title" value="<?php echo $fetch_result['title']; ?>"><br>
<a>本文(140文字)</a><br>
<textarea name="text" rows="3" cols="25"><?php echo $fetch_result['text']; ?></textarea><br>
<input type="submit" value="更新">
<a href="display.php">キャンセル</a>
</form>
<?php else: ?>
<a>お探しのページは一時的にアクセスできない状況にあるか、移動もしくは削除された可能性があります。</a><br>
<a href="display.php">掲示板トップページに戻る</a>
<?php endif; ?>
</body>
</html>
