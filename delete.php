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
<table border='1'>
<tr>
<th>ID</th>
<th>名前</th>
<th>タイトル</th>
<th>内容</th>
<th>記入年月日</th>
</tr>
<tr>
<td><?php echo $fetch_result['id']; ?></td>
<td><?php echo $fetch_result['name']; ?> </td>
<td><?php echo $fetch_result['title']; ?></td>
<td><?php echo $fetch_result['text']; ?></td>
<td><?php echo $fetch_result['uptime']; ?></td>
</tr>
</table>
<a href="delete_result.php?id=<?php echo $_GET['id']; ?>">削除</a>
<a href="display.php">キャンセル</a>
<?php else: ?>
<a>お探しのページは一時的にアクセスできない状況にあるか、移動もしくは削除された可能性があります。</a><br>
<a href="display.php">掲示板トップページに戻る</a>
<?php endif; ?>
</body>
</html>
