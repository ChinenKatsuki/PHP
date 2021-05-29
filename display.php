<?php
session_start();
require_once('common/db_connect.php');
$select_sql = 'SELECT worker_posts.id, workers.name, workers.image_name, worker_posts.title, worker_posts.text, worker_posts.uptime, worker_posts.worker_id, worker_posts.delete_text FROM workers INNER JOIN worker_posts ON worker_posts.worker_id = workers.id WHERE delete_text = 0 ORDER BY uptime DESC';
$select_result = $dbh->query($select_sql);
$select_result->execute();
$select_fetch = $select_result->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<?php if (!isset($_SESSION['name'])): ?>
<a href="register.php">新規投稿</a>&nbsp;
<a href="login.php">ログイン<a/>
<?php else: ?>
<a href="post.php">新規投稿</a>&nbsp;
<a href="logout.php">ログアウト</a>&nbsp;
<a href="user_info.php?id=<?php echo$_SESSION['id']; ?>"><?php echo $_SESSION['name']; ?></a>さんログイン中
<?php endif; ?>
<table border='1'>
<tr>
<th>ID</th>
<th>名前</th>
<th>ユーザー画像</th>
<th>タイトル</th>
<th>内容</th>
<th>記入年月日</th>
<th>編集・削除</th>
</tr>
<?php foreach ($select_fetch as $value): ?>
<tr>
<td><?php echo $value['id']; ?></td>
<th><a href="user_info.php?id=<?php echo $value['worker_id']; ?>"><?php echo $value['name']; ?></a></th>
<th>
<?php if ($value['image_name'] == null): ?>
<?php echo '未登録'; ?>
<?php else: ?>
<?php $img = base64_encode($value['image_name']); ?>
<img src="images/<?php echo $value['image_name']; ?>" width="100" height="100">
<?php endif; ?>
</th>
<td><?php echo $value['title']; ?></td>
<td><?php echo $value['text']; ?></td>
<td><?php echo $value['uptime']; ?></td>
<td>
<?php if ((isset($_SESSION['id'])) && ($_SESSION['id'] == $value['worker_id'])): ?>
<a href="edit.php?id=<?php echo $value['id']; ?>">編集</a>・
<a href="delete.php?id=<?php echo $value['id']; ?>">削除</a>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
