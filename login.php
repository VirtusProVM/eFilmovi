<?php  
require_once("config/configFile.php");
require_once("files/klase/Sanitizer.php");
require_once("files/klase/Account.php");
require_once("files/klase/Validator.php");

$account = new Account($conn);

if(isset($_POST['submitButton'])) {

	$username = Sanitizer::sanitizeFormUsername($_POST['username']);
	$password = Sanitizer::sanitizeFormPassword($_POST['password']);

	$success = $account->login($username, $password);

	if($success) {
		$_SESSION["userLoggedIn"] = $username;
		header("Location: index.php");
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
				
				<h2>Sign In</h2>
				<span>to contiue to Vrleflix</span>

			</div>
			
			<form method="POST">
				
				
				<?php echo $account->getError(Validator::$loginFailed); ?>
				<input type="text" name="username" placeholder="Username" value="<?php getSessionValue("username"); ?>" required />

				<input type="password" name="password" placeholder="Create password" required />

				<input type="submit" name="submitButton" value="LOGIN">
			</form>

			<a href="register.php" class="signInMessage">Need an account?Sign Up here</a>

		</div>
	</div>
</body>
</html>