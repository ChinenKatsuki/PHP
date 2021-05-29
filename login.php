<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title></title>
</head>
<body>
<a href="display.php">投稿一覧</a><br>
<form action="login_result.php" method="post">
メールアドレス:<input type="text" name="mail"><br>
パスワード:<input type="password" name="pass"><br>
<input type="submit" value="ログイン"><br>
登録がまだの方は<a href="register.php">こちら</a><br>
パスワードを忘れた方は<a href="password_form.php">こちら</a>
</form>
</body>
</html>
