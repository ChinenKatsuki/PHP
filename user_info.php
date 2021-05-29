<?php
session_start();
require_once('common/db_connect.php');
$select_sql = 'SELECT id, name, mail, text, image_name FROM workers WHERE id = :id';
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
<table border='1'>
<tr>
<th>名前</th>
<th>ユーザー画像</th>
<th>画像編集</th>
<th>メールアドレス</th>
<th>一言コメント</th>
<th>コメント編集</th>
</tr>
<tr>
<td><?php echo $fetch_result['name']; ?></td>
<td>
<?php if ($fetch_result['image_name'] == null): ?>
<?php echo '未登録'; ?>
<?php else: ?>
<img src="images/<?php echo $fetch_result['image_name']; ?>" width="100" height="100">
<?php endif; ?>
</td>
<td>
<?php if ((isset($_SESSION['id'])) && ($_SESSION['id'] == $fetch_result['id'])): ?>
<a href="user_edit_image.php?id=<?php echo $fetch_result['id']; ?>">編集</a>
<?php endif; ?>
<?php if ((isset($_SESSION['id'])) && ($_SESSION['id'] == $fetch_result['id']) && ($fetch_result['image_name'])): ?>
<a href="user_delete_image.php?id=<?php echo $fetch_result['id']; ?>">削除</a>
<?php endif; ?>
</td>
<td><?php echo $fetch_result['mail']; ?></td>
<td><?php echo $fetch_result['text']; ?></td>
<td>
<?php if ((isset($_SESSION['id'])) && ($_SESSION['id'] == $fetch_result['id'])): ?>
<a href="user_edit_comment.php?id=<?php echo $fetch_result['id']; ?>">編集</a>
<?php endif; ?>
</td>
</tr>
</table>
<a href="display.php">掲示板に戻る</a>
</body>
</html>
