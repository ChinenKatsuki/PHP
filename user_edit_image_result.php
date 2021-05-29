<?php
session_start();
$void_flag = true;

if (isset($_FILES['image'])) {
	if ($_FILES['image']['name'] != null) {
		if ((exif_imagetype($_FILES['image']['tmp_name']) == '1') || (exif_imagetype($_FILES['image']['tmp_name']) == '2') || (exif_imagetype($_FILES['image']['tmp_name']) == '3')) {
			if ($_FILES['image']['size'] <= '2000000') {
				$image_name = uniqid();
				$path = './images/';
				move_uploaded_file($_FILES['image']['tmp_name'], $path . $image_name);
				require_once('common/db_connect.php');
				$select_sql = 'SELECT id FROM workers WHERE id = :id';
				$select_result = $dbh->prepare($select_sql);
				$select_result->bindParam(':id', $_POST['id']);
				$select_result->execute();
				$fetch_result = $select_result->fetch(PDO::FETCH_ASSOC);
				if ($_SESSION['id'] == $fetch_result['id']) {
					$update_sql = 'UPDATE workers SET image_name = :image_name WHERE id = :id';
					$update_result = $dbh->prepare($update_sql);
					$update_result->bindParam(':id', $fetch_result['id']);
					$update_result->bindParam(':image_name', $image_name);
					$update_result->execute();
					$result_msg = '画像の登録ができました';
				} else {
					$error_msg = 'お探しのページは一時的にアクセスできない状況にあるか、移動もしくは削除された可能性があります';
					$void_flag = false;
				}
			} else {
				$result_msg = 'アップロードされたファイルが大きすぎます。他の画像を選んでください';
			}
		} else {
			$result_msg = '画像のタイプはjpeg,png,もしくは,gifの画像を選択して下さい';
		}
	} else {
		$result_msg = '画像を選択して下さい';
	}
} else {
	$result_msg = 'エラーが起きました。他の画像を選択して下さい';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
</head>
<body>
<?php if ($void_flag): ?>
<?php echo $result_msg; ?><br>
<a href="user_info.php?id=<?php echo $_SESSION['id']; ?>">マイページに戻る</a>
<?php else: ?>
<?php echo $error_msg; ?><br>
<a href="display.php">掲示板トップに戻る</a>
<?php endif; ?>
</body>
</html>
