<?php  

require_once("PayPal-PHP-SDK/autoload.php");

$apiContext = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'AUeJpUrFlnc0nq2dG3pUQ14qzJ2mRZ3qtBNNbBkY7wrZxO2yCpCaaBvtpokILApu4R0t7iBGkmuhvgvjbknlkj', 
		'EP10pJA8zv7eYJd4zcxev1PkVB6dt5Px2V8vOdzCPOYQG63X-oQ0S8MzyHM9FsDO5Pclorct5-WJtUNpjhvbnj'
	)
);
?>
