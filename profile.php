<?php  
require_once("files/header.php");
require_once("files/paypalConfig.php");
require_once("files/klase/Account.php");
require_once("files/klase/Validator.php");
require_once("files/klase/Sanitizer.php");
require_once("files/klase/BillingDetails.php");

$user = new User($conn, $userLoggedIn);
$detailsMessage = "";
$passwordMessage = "";
$clientMessage = "";

if(isset($_POST["saveDetailsButton"])) {
	$account = new Account($conn);

	$firstname = Sanitizer::sanitizeFormFullname($_POST["firstname"]);
	$lastname = Sanitizer::sanitizeFormFullname($_POST["lastname"]);
	$email = Sanitizer::sanitizeFormEmail($_POST["email"]);

	if($account->updateUser($firstname, $lastname, $email, $userLoggedIn)) {
		$detailsMessage = "<div class='alertSuccess'>
								Details update succesfull!
							</div>";
	} else {
		$errorMessage = $account->getFirstError();

		$detailsMessage = "<div class='alertError'>
								Details update succesfull!
							</div>";
	}
}

if(isset($_POST["savePasswordButton"])) {
	$account = new Account($conn);

	$oldPassword = Sanitizer::sanitizeFormPassword($_POST["oldPassword"]);
	$newPassword = Sanitizer::sanitizeFormPassword($_POST["newPassword"]);
	$confirmPassword = Sanitizer::sanitizeFormPassword($_POST["confirmPassword"]);

	if($account->updatePassword($oldPassword, $newPassword, $confirmPassword, $userLoggedIn)) {
		$passwordMessage = "<div class='alertSuccess'>
								Password update succesfull!
							</div>";
	} else {
		$errorMessage = $account->getFirstError();

		$passwordMessage = "<div class='alertError'>
								Details update succesfull!
							</div>";
	}
}

if (isset($_GET['success']) && $_GET['success'] == 'true') {
  $token = $_GET['token'];
  $agreement = new \PayPal\Api\Agreement();

  $clientMessage = "<div class='alertError'>
								Something went wrong!!!
							</div>";

  try {
    // Execute agreement
    $agreement->execute($token, $apiContext);

    $result = BillingDetails::insertBillingDetails($conn, $agreement, $token, $userLoggedIn);
    $result= $result && $user->setIsSubscribed(1);

    if($result) {
    	$clientMessage = "<div class='alertSuccess'>
								You're all signed up!!!
							</div>";
    }

  } catch (PayPal\Exception\PayPalConnectionException $ex) {
    echo $ex->getCode();
    echo $ex->getData();
    die($ex);
  } catch (Exception $ex) {
    die($ex);
  }
} else if (isset($_GET['success']) && $_GET['success'] == 'false') {
    $clientMessage = "<div class='alertSuccess'>
								Client canceled paymants
							</div>";
}
?>

<div class="settingsContainer column">
	<div class="formSection">
		<form method="POST">
			<h2>User Details</h2>

			<?php 

			$firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : $user->getFirstname();
			$lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : $user->getLastname();
			$email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();
			?>

			<input type="text" name="firstname" placeholder="Update first name" value="<?php echo $firstname; ?>">
			<input type="text" name="lastname" placeholder="Update last name" value="<?php echo $lastname; ?>">
			<input type="email" name="email" placeholder="Update email" value="<?php echo $email; ?>">

			<div class="message">
				<?php echo $detailsMessage; ?>
			</div>


			 <input type="submit" name="saveDetailsButton" value="Save">
		</form>
	</div>

	<div class="formSection">
		<form method="POST">
			<h2>Update password</h2>

			<input type="password" name="oldPassword" placeholder="Old password">
			<input type="password" name="newPassword" placeholder="New password">
			<input type="password" name="confirmPassword" placeholder="Confirm password">

			<div class="message">
				<?php echo $passwordMessage; ?>
			</div>

			 <input type="submit" name="savePasswordButton" value="Save">
		</form>
	</div>

	<div class="formSection">
		<h3>Subscription</h3>

		<div class="message">
				<?php echo $clientMessage; ?>
			</div>

		<?php 
			if($user->isSubscribed()) {
				echo "<h3>You are subscribed!Go to pay pal to cancel</h3>";
			} else {
				echo "<a href='billing.php'>Subscribe to Vrleflix</a>";
			}
		?>
	</div>
</div>