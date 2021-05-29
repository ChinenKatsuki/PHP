<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<form action="post_result.php" method="post">
<a>投稿者名</a><br>
<?php echo $_SESSION['name']; ?><br>
<a>タイトル(15文字)</a><br>
<input type="text" name="title" ><br>
<a>本文(140文字)</a><br>
<textarea name="text" rows="4"></textarea><br>
<input type="submit" value="投稿する"><br>
</form>
</body>
</html>

