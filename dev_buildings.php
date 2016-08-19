<!DOCTYPE html>
<html data-bind="css: SpaceGame.apiStatus()">
	<?php include_once('meta/header.php'); ?>
	<body>
		<div class="container row">
			<div class="game_frame col s12">
				<!-- <div class="building_list row" data-bind="foreach: SpaceGame.db_buildings">
					<div class="building col s12 m6">
						<span data-bind="text:id()" class="hidden"></span>
						<table>
							<tr>
								<td rowspan="3"><span data-bind="text:level()" class="level"></span></td>
								<td data-bind="text:name()" class="name"></td>
								<td rowspan="3">
									<span data-bind="click: startBuilding" class="startBuilding">
										<i class="fa fa-gavel" aria-hidden="true"></i>
									</span>
								</td>
							</tr>
							<tr>
								<td data-bind="text:description()" class="description"></td>
							</tr>
							<tr>
								<td data-bind="text:buildTimeText()" class="buildTime"></td>
							</tr>
						</table>
					</div>
				</div> -->
			</div>
		</div>
	</body>
	<?php include_once('meta/footer.php'); ?>
</html>