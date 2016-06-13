<div class="container">
	<h3>Database Buildings</h3>
	<div class="building_list row" data-bind="foreach: SpaceGame.db_buildings">
		<div class="building col s12 m6">
			<span data-bind="text:id()" class="hidden"></span>
			<!-- <span data-bind="text:upgradeTime(), click: StartCounter, visible: !isRunning()" class="upgradeTime"></span> -->
			<!-- <span data-bind="text:elapsedTime()"></span> -->
			<!-- <span data-bind="text:remainingTime() , visible: isRunning()" class="remainingTime"></span> -->
			<table>
				<tr>
					<td rowspan="3"><!-- <span data-bind="text:level()" class="level"></span> --></td>
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
	</div>
	<!-- User Buildings -->
	<h3>USER Buildings</h3>
	<div class="building_list row" data-bind="foreach: SpaceGame.user_buildings">
		<div class="building col s12 m6" data-bind="css: {running: isRunning()}, attr: { style: progressWidth }">
			<span data-bind="text:id()" class="hidden"></span>
			<table>
				<tr>
					<td rowspan="3" data-bind="text:level()" class="level"</td>
					<td data-bind="text:name()" class="name td_info"></td>
					<td rowspan="3">
						<span data-bind="click: StartCounter, visible: !isRunning()" class="startBuilding">
							<i class="fa fa-wrench" aria-hidden="true"></i>
						</span>
						<span data-bind="text:remainingTimeText() , visible: isRunning()" class="remainingTime"></span>
					</td>
				</tr>
				<tr>
					<td data-bind="text:description()" class="description td_info"></td>
				</tr>
				<tr>
					<td data-bind="text:buildTimeText()" class="buildTime td_info"></td>
				</tr>
			</table>
		</div>
	</div>
</div>
