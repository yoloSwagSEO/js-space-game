<!DOCTYPE html>
<html data-bind="css: SpaceGame.apiStatus()">
	<?php include_once('meta/header.php'); ?>
	<body>
		<div class="content">
			<div class="building_list" data-bind="foreach: SpaceGame.db_buildings">
				<div class="building">
					<span data-bind="text:id()" class="hidden"></span>
					<!-- <span data-bind="text:level()" class="level"></span> -->
					<span data-bind="text:name()" class="name"></span>
					<span data-bind="text:description()" class="description"></span>
					<!-- <span data-bind="text:upgradeTime(), click: StartCounter, visible: !isRunning()" class="upgradeTime"></span> -->
					<!-- <span data-bind="text:elapsedTime()"></span> -->
					<!-- <span data-bind="text:remainingTime() , visible: isRunning()" class="remainingTime"></span> -->
				</div>
			</div>
		</div
	</body>
	<?php include_once('meta/footer.php'); ?>
</html>
