<?php  

class Validator {

	public static $firstnameCharacter = "Your first name must be between 2 and 25 characters.";
	public static $lastnameCharacter = "Your last name must be between 2 and 25 characters";
	public static $usernameCharacter = "Your user name must be between 2 and 25 characters";
	public static $usernameAlreadyExist = "This email is already in use.Please provide another email.";
	public static $emailDontMatch = "Your email don't match";
	public static $invalidEmail = "Invalid email";
	public static $emailAlreadyInUse = "This email is alread in use by another client";
	public static $passwordDontMatch = "Password don't match";
	public static $passwordLength = "Your password must be between 9 and 30 characters";
	public static $loginFailed = "Your username or password are incorrect";
	public static $passwordIncorrect = "Your password is incorrect";
}

?>