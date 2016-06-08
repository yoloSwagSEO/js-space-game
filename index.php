<!DOCTYPE html>
<html>
	<?php include_once('meta/header.php'); ?>
	<body>
		<div class="content" data-bind="css:Game.apiStatus()">
			<div class="building_list" data-bind="foreach: Game.buildings">
				<div class="building" data-bind="css: { upgrading: isRunning() == true }">
					<span data-bind="text:id()" class="hidden"></span>
					<span data-bind="text:level()"></span>
					<span data-bind="text:info()" class="info"></span>
					<span data-bind="text:upgradeTime(), click: StartCounter, visible: !isRunning()" class="upgradeTime"></span>
					<!-- <span data-bind="text:elapsedTime()"></span> -->
					<span data-bind="text:remainingTime() , visible: isRunning()" class="remainingTime"></span>
				</div>
			</div>
		</div
	</body>
	<?php include_once('meta/footer.php'); ?>
</html>
