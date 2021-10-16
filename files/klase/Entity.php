<?php  

class Entity {
	
	private $conn;
	private $sqlData;

	public function __construct($conn, $input) {
		$this->conn = $conn;

		if(is_array($input)) {
			$this->sqlData = $input;
		} else {
			$query = $this->conn->prepare("SELECT * FROM entities WHERE id=:id");
			$query->bindValue(":id", $input);
			$query->execute();

			$this->sqlData = $query->fetch(PDO::FETCH_ASSOC);

		}
	}

	public function getID() {
		return $this->sqlData["id"];
	}

	public function getName() {
		return $this->sqlData["name"];
	}

	public function getThumbnail() {
		return $this->sqlData["thumbnail"];
	}

	public function getPreview() {
		return $this->sqlData["preview"];
	}

	public function getCategoryID() {
		return $this->sqlData["categoryId"];
	}

	public function getSeasons() {
		$query = $this->conn->prepare("SELECT * FROM videos WHERE entityId=:id AND isMovie=0 
			ORDER BY season, episode ASC");

		$query->bindValue(":id", $this->getID());
		$query->execute();

		$season = array();
		$videos = array();
		$currentSeason = null;

		while($row = $query->fetch(PDO::FETCH_ASSOC)) {

			if($currentSeason != null && $currentSeason != $row["season"]) {
				$season[] = new Season($currentSeason, $videos);
				$videos = array();
			}

			$currentSeason = $row["season"];
			
			$videos[] = new Video($this->conn, $row);
		}

		if(sizeof($videos) != 0) {
			$season[] = new Season($currentSeason, $videos);
		}
		return $season;
	}
}


?>