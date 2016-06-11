<?php
require('api/db_connect.php');

//if logged in redirect to Users page
if( $user->is_logged_in() ){ header('Location: game.php'); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	//very basic validation
	if(strlen($_POST['username']) < 3){
		$error[] = 'Username is too short.';
	} else {
		$stmt = $db->prepare('SELECT username FROM Users WHERE username = :username');
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
		$stmt = $db->prepare('SELECT email FROM Users WHERE email = :email');
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
			$stmt = $db->prepare('INSERT INTO Users (username,password,email,active) VALUES (:username, :password, :email, :active)');
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
	<div class="right_content">
	    <div class="user_register">
			<form role="form" method="post" action="" autocomplete="off">
				<h2>Sign Up</h2>
				<hr>
				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<p class='bg-success'>Registration successful, please check your email to activate your account.</p>";
				}
				?>

				<table class="user-form-table">
					<tr>
						<td colspan="2">
							<input type="text" name="username" id="username" maxlength="35" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo $_POST['email']; } ?>" tabindex="2">
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
						</td>
						<td>
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="button-row"><button type="submit" name="submit" value="Register" class="button fill button-primary button-block button-lg" tabindex="5">Register</button></div>
						</td>
					</tr>
				</table>

			</form>
		</div>
	</div>
</div>

<?php
//include footer template
require('meta/footer.php');
?>
