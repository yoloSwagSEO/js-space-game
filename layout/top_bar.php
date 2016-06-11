<?php
//if logged
$isLoggedin = 'loggedOut';
if($user->is_logged_in()){ $isLoggedin='loggedIn'; }
?>

<div class="top_bar <?php echo $isLoggedin; ?>">
	<div class="container">
		<div id="hamburger">
			<div></div>
			<div></div>
			<div></div>
		</div>
		<a href="index.php">Js-Space-Game</a>
		<div class="user_bar logout">
			<!-- <span class="notification-btn btn">
				<i class="fa fa-bell-o"></i>
			</span> -->
		 	<i class="fa fa-user"></i>
			<span><?php echo $_SESSION['username']; ?></span>
			<span class="user_logout">
				<a class="btn btn-social-icon btn-social-icon-with-count btn-logout" href="logout.php">
					<i class="fa fa-sign-out"></i>
					<span class="btn-count">Logout</span>
				</a>
			</span>
		</div>
		<div class="user_bar login">
			<span class="info">Already a member?</span>
			<span class="user_login">
				<a class="btn btn-social-icon btn-social-icon-with-count btn-login" href="login.php">
					<i class="fa fa-sign-in"></i>
					<span class="btn-count">Login</span>
				</a>
			</span>
		</div>
	</div>
</div>
