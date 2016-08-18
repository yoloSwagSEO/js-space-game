<footer>
	<!-- StyleSheets -->
	<link href="css/dist/main.css" rel="stylesheet" type="text/css">
<?php if(file_exists("js/script.js")){ ?>
	<!-- main.js -->
	<script type="text/javascript" src="js/script.js"></script>
	<!-- Objects.js -->
	<!-- TODO: load with requireJS -->
	<script type="text/javascript" src="js/koObjects/core_db_data.js"></script>
	<script type="text/javascript" src="js/koObjects/user_data.js"></script>
<?php }else{ ?>
	<!-- MINIFIED -->
	<script type="text/javascript" src="js/dist/composite.all.min.js"></script>
<?php } ?>
</footer>
