<?php  

class User {
	
	private $conn;
	private $sqlData;

	function __construct($conn, $username) {
		$this->conn = $conn;
		$this->username = $username;

		$query = $conn->prepare("SELECT * FROM users WHERE username=:username");
		$query->bindValue(":username", $username);
		$query->execute();

		$this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
	}

	public function getFirstname() {
		return $this->sqlData["firstname"];
	}

	public function getLastname() {
		return $this->sqlData["lastname"];
	}

	public function getEmail() {
		return $this->sqlData["email"];
	}

	public function isSubscribed() {
		return $this->sqlData["isSubscribed"];
	}

	public function getUsername() {
		return $this->sqlData["username"];
	}

	public function setIsSubscribed($value) {
		$query = $this->conn->prepare("UPDATE users SET isSubscribed=:isSubscribed WHERE username=:un");

		$query->bindValue(":isSubscribed", $value);
		$query->bindValue(":un", $this->getUsername());

		
		if($query->execute()) {
			$this->sqlData["isSubscribed"] = $value;

			return true;
		}
		return false;
	}
}

?>