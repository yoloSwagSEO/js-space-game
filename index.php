<?php
require('api/db_connect.php');

//if logged in redirect to users page
if( $user->is_logged_in() ){ header('Location: game.php'); }
//very basic validation
//if form has been submitted process it
if(isset($_POST['submit'])){

	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM users WHERE username = :username');
		$stmt->execute(array(':username' => $_POST['username']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}
	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM users WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}
	}


	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO users (username,password,email,active) VALUES (:username, :password, :email, :active)');
			$stmt->execute(array(
				':username' => $_POST['username'],
				':password' => $hashedpassword,
				':email' => $_POST['email'],
				':active' => $activasion
			));
			$id = $db->lastInsertId('id');

			//send email
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "Thank you for registering at demo site.\n\n To activate your account, please click on this link:\n\n ".DIR."activate.php?x=$id&y=$activasion\n\n Regards Site Admin \n\n";
			$additionalheaders = "From: <".SITEEMAIL.">\r\n";
			$additionalheaders .= "Reply-To: ".SITEEMAIL."";
			mail($to, $subject, $body, $additionalheaders);
			//redirect to index page
			header('Location: index.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
				$error[] = $e->getMessage();
		}

	}

}

//define page title
$title = '';

//include header template
require('meta/header.php');
?>
<div class="container">
	<div class="row">
		<div class="user_register col offset-m8 m4 s12">
			<div class="user_bar login">
				<span class="info">Already a member?</span>
				<span>
					<a href="login.php">
						<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-button--colored">
							<i class="fa fa-sign-in"></i>
							<span class="btn-count">Login</span>
						</button>
					</a>
				</span>
			</div>
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Sign Up</h2>
				<hr>
						<?php
						//check for any errors
						if(isset($error)){
							echo '<div class="alert error">';
							foreach($error as $error){
								echo '<p>'.$error.'</p>';
							}
							echo '</div>';
						}
						?>

				<?php
				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<p class='alert success'>Registration successful, please check your email to activate your account.</p>";
				}
				?>
				<div class="row">
					<div class="mdl-textfield mdl-js-textfield col s12">
						<input class="mdl-textfield__input" type="text" id="username" name="username" placeholder="Username" maxlength="35" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
						<label class="mdl-textfield__label" for="username"> </label>
					</div>
					<div class="mdl-textfield mdl-js-textfield col s12">
						<input class="mdl-textfield__input" type="email" id="email" name="email" placeholder="Email" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2">
						<label class="mdl-textfield__label" for="email"></label>
					</div>
					<div class="mdl-textfield mdl-js-textfield col s6">
						<input class="mdl-textfield__input" type="password" id="password" name="password" placeholder="Password" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="3">
						<label class="mdl-textfield__label" for="password"></label>
					</div>
					<div class="mdl-textfield mdl-js-textfield col s6">
						<input class="mdl-textfield__input" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Password Confirm" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="4">
						<label class="mdl-textfield__label" for="passwordConfirm"></label>
					</div>
					<div class="button-row  col s6">
						<button  type="submit" name="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"  tabindex="5">
							Register
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
//include footer template
require('meta/footer.php');
?>
