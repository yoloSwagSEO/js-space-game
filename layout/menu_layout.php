<?php
//if logged
$isLoggedin = 'loggedOut';
if ($user->is_logged_in()) {
	$isLoggedin='loggedIn';
}else{
	header('Location: index.php');
}
?>

<div id="hamburger">
	<div></div>
	<div></div>
	<div></div>
</div>
<div class="user_frame <?php echo $isLoggedin; ?>">
	<div class="user_bar logout">
		<span class="user_logout">
			<div class="profile_frame">
				<span><img class="img" src="./imgs/avatar/sauroneye.jpg" alt="" /></span>
				<span class="username"><?php echo $_SESSION['username']; ?></span>
			</div>
			<a href="logout.php">
				<button class="mdl-button mdl-js-button mdl-js-ripple-effect">
					<i class="fa fa-sign-out"></i>
					<span class="btn-count">Logout</span>
				</button>
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
<div class="links_frame">
	<ul>
		<li>Starbase</li>
		<li>Shipyard</li>
		<li>Research Center</li>
	</ul>
</div>
