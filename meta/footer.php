<footer>
	<!-- StyleSheets -->
	<link href="css/dist/main.css" rel="stylesheet" type="text/css">

	<!-- MINIFIED -->
	<!-- <script type="text/javascript" src="js/dist/composite.all.min.js"></script> -->
	<!-- main.js -->
	<script type="text/javascript" src="js/script.js"></script>
	<!-- Objects.js -->
	<!-- TODO: load with requireJS -->
	<script type="text/javascript" src="js/koObjects/core_db_data.js"></script>
	<script type="text/javascript" src="js/koObjects/user_data.js"></script>
<?php

if(file_exists("js/script.js")){
	echo "exists";
}else{
	echo "not there";
}
 ?>
</footer>
