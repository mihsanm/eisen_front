<!DOCTYPE html>
<html lang="ja">
<?php
$title = "Untitled Document";
require_once __DIR__ .'/parts/head.php';
?>
<body>
	<div class="wrapper">
		<div class="contentwrapper-nonav">
			<main class="contents">
				<div class="inner inner-login">
					<div class="login-header">
						<!-- ここにロゴ画像を挿入 -->
						<span>ログイン</span>
					</div>
					<div class="login">
						<form action='includes/login.php' method='POST'>
							<span>ユーザーID</span>
							<input type="text" name="user_name">
							<span>パスワード</span>
							<input type="password" name="password">
							<input type="submit" value="ログイン" class="button" />
						</form>
					</div>
				</div>
			</main>
		</div>
	</div>
	<script type="text/javascript" src="js/script.js"></script>
</body>

</html>
