<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<a>パスワード再設定画面</a>
<form action="password_reregister_result.php" method="post">
<input type="hidden" name="key" value="<?php echo $_GET['key']; ?>">
<a>新パスワード</a><br>
<input type="password" name="new_pass"><br>
<a>新パスワード(確認)</a><br>
<input type="password" name="new_pass_confirm"><br>
<input type="submit" value="登録">
</form>
</body>
</html>

