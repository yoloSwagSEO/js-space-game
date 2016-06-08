<!DOCTYPE html>
<html>
	<?php include_once('meta/header.php'); ?>
	<body>
		<div class="content" data-bind="css:Game.apiStatus()">
			<div class="building_list" data-bind="foreach: Game.buildings">
				<div class="building">
					<span data-bind="text:id()"></span>
					<span data-bind="text:level()"></span>
					<span data-bind="text:info()" class="info"></span>
					<span data-bind="text:upgradeTime()"></span>
					<!-- <span data-bind="text:elapsedTime()"></span> -->
					<span data-bind="text:remainingTime()" class="time"></span>
					<button class="btn" style="margin-top:5px" id="StartCounter" data-bind="click: StartCounter, visible: !isRunning()">
						start
		    	</button>
				</div>
			</div>
		</div
	</body>
	<?php include_once('meta/footer.php'); ?>
</html>
