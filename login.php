<?php
//include config
require_once('api/db_connect.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: game.php'); }

//check if the rememberme cookie is present
if(isSet($_COOKIE['SILLY'])) {
	if($user->get_remember_me()){
		header('Location: game.php');
		exit;
	}
}

//process login form if submitted
if(isset($_POST['submit'])){

	$username = $_POST['username'];
	$password = $_POST['password'];
	$rememberme = $_POST['remember_me'];
	if($username && $password){
		if($user->login($username, $password, $rememberme)){
			$_SESSION['username'] = $username;
			header('Location: game.php');
			exit;
		} else {
			$error[] = 'Wrong username or password or your account has not been activated.';
		}
	}else{
		$error[] = 'Please enter username and password.';
	}

}//end if submit

//define page title
$title = 'Login';

//include header template
require('meta/header.php');
?>


<div class="container">
	<div class="">
			<div class="user_login">
			<form role="form" method="post" action="" autocomplete="on">
				<h2>Login</h2>
				<p><a href='./'>Back to home page</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				if(isset($_GET['action'])){

					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
							break;
						case 'resetAccount':
							echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
							break;
					}

				}


				?>
				<div class="row">
					<div class="mdl-textfield mdl-js-textfield col s6">
						<input class="mdl-textfield__input" type="text" id="username" name="username" placeholder="Username" maxlength="35" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
						<label class="mdl-textfield__label" for="username"> </label>
					</div>
					<div class="mdl-textfield mdl-js-textfield col s6">
						<input class="mdl-textfield__input" type="password" id="password" name="password" placeholder="Password" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="3">
						<label class="mdl-textfield__label" for="password"></label>
					</div>
					<div class="">
						<a href='reset.php'>Forgot your Password?</a>
					</div>
				</div>
				<div class="button-row">
					<button type="submit" name="submit"  class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-button--colored">
						<i class="fa fa-sign-in"></i>
						<span class="btn-count">Login</span>
					</button>
					<input type="checkbox" id="remember_me" name="remember_me" <?php echo isset($_COOKIE['checkIT']) ? 'checked' : ''; ?> />
						<label for="remember_me">Keep me logged in</label>
				</div>
			</form>
		</div>
	</div>
</div>


<?php
//include header template
require('meta/footer.php');
?>
