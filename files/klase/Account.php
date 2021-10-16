<?php  


class Account {

	private $conn;
	private $errorArray = array();
	
 	public function __construct($conn) {
		$this->conn = $conn;
	}

	public function updateUser($fn, $ln, $em, $un) {
		$this->validateFirstname($fn);
		$this->validateLastname($ln);
		$this->validateNewEmail($em, $un);

		if(empty($this->errorArray)) {
			$query = $this->conn->prepare("UPDATE users SET firstname=:fn, lastname=:ln, email=:em WHERE username=:un");

			$query->bindValue(":fn", $fn);
			$query->bindValue(":ln", $ln);
			$query->bindValue(":em", $em);
			$query->bindValue(":un", $un);

			return $query->execute();
		}

		return false;
	}

	public function validateNewEmail($em, $un) {
		if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
			array_push($this->errorArray, Validator::$invalidEmail);
			return;
		}

		$query = $this->conn->prepare("SELECT * FROM users WHERE email=:em AND username !=:un");
		$query->bindValue(":em", $em);
		$query->bindValue(":un", $un);
		$query->execute();

		if($query->rowCount() != 0) {
			array_push($this->errorArray, Validator::$emailTaken);
		}
	}

	public function register($fn, $ln, $un, $em, $em2, $pw, $pw2) {
		$this->validateFirstname($fn);
		$this->validateLastname($ln);
		$this->validateUsername($un);
		$this->validateEmail($em, $em2);
		$this->validatePassword($pw, $pw2);

		if(empty($this->errorArray)) {
			return $this->insertUserIntoDatabase($fn, $ln, $un, $em, $pw);
		} 
		return false;
	}

	public function login($un, $pw) {
		$pw = hash("sha512", $pw);

		$query = $this->conn->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");

		$query->bindValue(":un", $un);
		$query->bindValue(":pw", $pw);

		$query->execute();

		if($query->rowCount() == 1) {
			return true;
		}

		array_push($this->errorArray, Validator::$loginFailed);
		return false;
	}

	private function insertUserIntoDatabase($fn, $ln, $un, $em, $pw) {
		$pw = hash("sha512", $pw);

		$query = $this->conn->prepare("INSERT INTO users(firstname, lastname, username, email, password) VALUES 
			(:fn, :ln, :un, :em, :pw)");

		$query->bindValue(":fn", $fn);
		$query->bindValue(":ln", $ln);
		$query->bindValue(":un", $un);
		$query->bindValue(":em", $em);
		$query->bindValue(":pw", $pw);

		return $query->execute(); 
	}

	private function validateFirstname($fn) {
		if(strlen($fn) < 2 || strlen($fn) > 25) {
			array_push($this->errorArray, Validator::$firstnameCharacter);
		}
	}

	private function validateLastname($ln) {
		if(strlen($ln) < 2 || strlen($ln) > 25) {
			array_push($this->errorArray, Validator::$lastnameCharacter);
			return;
		}
	}

	private function validateUsername($un) {
		if(strlen($un) < 2 || strlen($un) > 25) {
			array_push($this->errorArray, Validator::$usernameCharacter);
		}

		$query = $this->conn->prepare("SELECT * FROM users WHERE username=:un");
		$query->bindValue(":un", $un);

		$query->execute();

		if($query->rowCount() != 0) {
			array_push($this->errorArray, Validator::$usernameAlreadyExist);
		}
	}

	private function validateEmail($em, $em2) {
		if($em != $em2) {
			array_push($this->errorArray, Validator::$emailDontMatch);
			return;
		} 

		if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
			array_push($this->errorArray, Validator::$invalidEmail);
			return;
		}

		$query = $this->conn->prepare("SELECT * FROM users WHERE email=:em");
		$query->bindValue(":em", $em);
		$query->execute();

		if($query->rowCount() != 0) {
			array_push($this->errorArray, Validator::$emailAlreadyInUse);
		}
	}

	private function validatePassword($pw, $pw2) {
		if($pw != $pw2) {
			array_push($this->errorArray, Validator::$passwordDontMatch);
			return;
		}

		if(strlen($pw) < 8 || strlen($pw) > 30) {
			array_push($this->errorArray, Validator::$passwordLength);
			return;
		}
	}



	public function getError($error) {
		if(in_array($error, $this->errorArray)) {
			return "<span class='errorMessage'>$error</span>";
		}
	}

	public function getFirstError() {
		if(!empty($this->errorArray)) {
			return $this->errorArray[0];
		}
	}

	public function updatePassword($oldPassword, $pw, $pw2, $un) {
		$this->validateOldPassword($oldPassword, $un);
		$this->validatePassword($pw, $pw2);

		if(empty($this->errorArray)) {
			$query = $this->conn->prepare("UPDATE users SET password=:pw WHERE username=:un");
			$pw = hash("sha512", $pw);
			$query->bindValue(":pw", $pw);
			$query->bindValue(":un", $un);

			return $query->execute();
		}

		return false;
	}

	public function validateOldPassword($pw, $un) {
		$pw = hash("sha512", $pw);

		$query = $this->conn->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");

		$query->bindValue(":un", $un);
		$query->bindValue(":pw", $pw);

		$query->execute();

		if($query->rowCount() == 0) {
			
			array_push($this->errorArray, Validator::$passwordIncorrect);
		}

	}
}



?>