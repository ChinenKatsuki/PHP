<?php
session_start();
require_once('common/db_connect.php');
$select_sql = 'SELECT id, name, text FROM workers WHERE id = :id';
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
<?php if ($_SESSION['id'] == $fetch_result['id']): ?>
<form action="user_edit_comment_result.php" method="post">
<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"><br>
<a>一言コメント</a><br>
<textarea name="text"><?php echo $fetch_result['text']; ?></textarea><br>
<input type="submit" value="登録">
</form>
<?php else: ?>
<a>お探しのページは一時的にアクセスできない状況にあるか、移動もしくは削除された可能性があります。</a><br>
<a href="display.php">掲示板トップページに戻る</a>
<?php endif; ?>
</body>
</html>

