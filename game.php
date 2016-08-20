<?php
	require_once('api/db_connect.php');
	require_once('api/classes/user.php');
?>
<!DOCTYPE html>
<html data-bind="css: SpaceGame.apiStatus()">
	<?php include_once('meta/header.php'); ?>
	<body>
		<div class="container row">
			<div class="menu_frame col s12 m3">
				<?php include_once("layout/menu_layout.php") ?>
			</div>
			<div class="game_frame col s12 m9">
				<?php include_once("layout/hq_layout.php") ?>
			</div>
		</div>
	</body>
	<?php include_once('meta/footer.php'); ?>
</html>
