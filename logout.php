<?php
session_start();
$_SESSION = null;
if (isset($_COOKIE['session_name()'])) {
	setcookie(session_name(), '', time() - 3600, '/');
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<a>ログアウトしました</a>
<a href="login.php">ログインページに戻る</a>
</body>
</html>


