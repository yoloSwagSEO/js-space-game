<div class="container">
	<h4>Buildings</h4>
	<div class="from_db building_list row" data-bind="foreach: SpaceGame.db_buildings">
		<div class="building_frame col s12 m6 l4">
			<div class="building">
				<span data-bind="text:id()" class="hidden"></span>
				<div class="info_layer">
						<div data-bind="text:name()" class="name"></div>
						<div data-bind="text:description()" class="description"></div>
				</div>
				<div class="build_layer">
					<span class="left">
						<span class="powers">
							<div class="power_table" data-bind="foreach: powers()">
								<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'+'+(value() * $parent.powerMultiplier()).toFixed(1)"></span></div>
							</div>
						</span>
						<span class="costs">
							<div class="power_table" data-bind="foreach: resources()">
								<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'-'+(value() * $parent.resourceMultiplier()).toFixed(1)"></span></div>
							</div>
						</span>
					</span>
					<span class="right">
						<span class="action startBuilding" data-bind="click: startBuilding">
							<i class="icon fa fa-gavel" aria-hidden="true"></i>
							<div class="buildTime" data-bind="text:buildTimeText()"></div>
						</span>
					</span>
				</div>
			</div>
		</div>
	</div>
	<!-- User Buildings -->
	<h4>Active Buildings</h4>
	<div class="from_user building_list row" data-bind="foreach: SpaceGame.user_buildings">
		<div class="building_frame col s12 m6 l4">
			<div class="building" data-bind="css: {running: isRunning()}">
				<span data-bind="text:id()" class="hidden"></span>
				<div class="info_layer">
						<div data-bind="text:name()" class="name"></div>
						<div data-bind="text:description()" class="description"></div>
						<div class="progressbar" data-bind="attr: { style: progressWidth }"></div>
				</div>
				<div class="build_layer" data-bind="css: {running: isRunning()}">
					<span class="left">
						<span class="powers">
							<div class="ress"><span class="kind level">Level</span><span class="value" data-bind="text:level()"></span></div>
							<div class="power_table" data-bind="foreach: powers()">
								<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'+'+(value() * $parent.powerMultiplier()).toFixed(1)"></span></div>
							</div>
						</span>
						<span class="costs">
							<div class="power_table" data-bind="foreach: resources()">
								<div class="ress"><span class="kind" data-bind="text:name()"></span><span class="value" data-bind="text:'-'+(value() * $parent.resourceMultiplier()).toFixed(1)"></span></div>
							</div>
						</span>
					</span>
					<span class="right">
						<span class="action startBuilding" data-bind="click: function(){ StartCounter(true, 0); console.log('wtf!!!'); }, visible: !isRunning()">
							<i class="icon fa fa-wrench" aria-hidden="true"></i>
							<span class="buildTime" data-bind="text:buildTimeText()"></span>
						</span>
						<div class="action loading" data-bind="visible: isRunning()">
								<div class="icon ring"></div>
								<div class="buildTime" data-bind="text:remainingTimeText()"></div>
						</div>
					</span>
				</div>
			</div>
		</div>
	</div>
	<h4>Building in progress</h4>
	<div class="in_progress building_list row">
	</div>
</div>
