<?php  

require_once("config/configFile.php");
require_once("files/klase/Sanitizer.php");
require_once("files/klase/Account.php");
require_once("files/klase/Validator.php");

$account = new Account($conn);

if(isset($_POST['submitButton'])) {

	$firstname = Sanitizer::sanitizeFormFullname($_POST['firstName']);
	$lastname = Sanitizer::sanitizeFormFullname($_POST['lastName']);
	$username = Sanitizer::sanitizeFormUsername($_POST['username']);
	$email = Sanitizer::sanitizeFormEmail($_POST['email']);
	$email2 = Sanitizer::sanitizeFormEmail($_POST['confirmEmail']);
	$password = Sanitizer::sanitizeFormPassword($_POST['password']);
	$password2 = Sanitizer::sanitizeFormPassword($_POST['confirmPassword']);

	$success = $account->register($firstname, $lastname, $username, $email, $email2, $password, $password2);

	if($success) {
		$_SESSION["userLoggedIn"] = $username;
		header("Location:index.php");
	}

}


function getSessionValue($inputText) {
	if(isset($_POST['$inputText'])) {
		echo $_POST['inputText'];
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome! Please register to see content!!!</title>
	<link rel="stylesheet" type="text/css" href="files/style/vrleflix.css">
</head>
<body>
	

	<div class="registerContainer">
		
		<div class="column">

			<div class="header">

				<a href="https://fontmeme.com/netflix-font/"><img src="https://fontmeme.com/permalink/210818/498aedf64bccb2a1300b4b8dfe9fb7ac.png" alt="netflix-font" border="0"></a>
				
				<h2>Sign Up</h2>
				<span>to continue to Vrleflix</span>

			</div>
			
			<form method="POST">
				
				<?php echo $account->getError(Validator::$firstnameCharacter); ?>
				<input type="text" name="firstName" placeholder="First Name" value="<?php getSessionValue("firstName"); ?>" required />

				<?php echo $account->getError(Validator::$lastnameCharacter); ?>
				<input type="text" name="lastName" placeholder="Last Name"  value="<?php getSessionValue("lastName"); ?>"  required />

				<?php echo $account->getError(Validator::$usernameCharacter); ?>
				<?php echo $account->getError(Validator::$usernameAlreadyExist); ?>
				<input type="text" name="username" placeholder="Username"  value="<?php getSessionValue("username"); ?>" required />

				<?php echo $account->getError(Validator::$emailDontMatch); ?>
				<?php echo $account->getError(Validator::$invalidEmail); ?>
				<?php echo $account->getError(Validator::$emailAlreadyInUse); ?>
				<input type="email" name="email" placeholder="Enter your email"  value="<?php getSessionValue("email"); ?>" required />

				<input type="email" name="confirmEmail" placeholder="Confirm your email"  value="<?php getSessionValue("confirmEmail"); ?>" required />

				<?php echo $account->getError(Validator::$passwordDontMatch); ?>
				<?php echo $account->getError(Validator::$passwordLength); ?>
				<input type="password" name="password" placeholder="Create password" required />

				<input type="password" name="confirmPassword" placeholder="Confirm your password" required>	

				<input type="submit" name="submitButton" value="REGISTER">
			</form>

			<a href="login.php" class="signInMessage">Already have an account?Sign In here</a>

		</div>
	</div>
</body>
</html>