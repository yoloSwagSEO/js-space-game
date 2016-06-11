<?php
//include config
require_once('api/db_connect.php');

//check if already logged in move to home page
if( $user->is_logged_in() ){ header('Location: index.php'); }

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
	<div class="right_content">
	    <div class="user_register">
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
				<table class="user-form-table">
					<tr>
						<td>
							<input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
						</td>
					</tr>
				</table>
				<div class="">
					<a href='reset.php'>Forgot your Password?</a>
				</div>
				<hr>
				<div class="row">
					<div class="button-row"><button type="submit" name="submit" value="Login" class="button fill button-primary button-block button-lg" tabindex="5">Login</button></div>
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
