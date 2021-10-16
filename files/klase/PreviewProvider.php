<?php  

class PreviewProvider {

	private $conn;
	private $username;
	
	public function __construct($conn, $username) {
		$this->conn = $conn;
		$this->username = $username;
	}

	public function createTVShowPreviewVideo() {
		$entitiesArray = EntityProvider::getTVShowsEntities($this->conn, null, 1);

		if(sizeof($entitiesArray) == 0) {
			ErrorMessage::show("No tv shows to display");
		}

		return $this->createPreviewVideo($entitiesArray[0]);
	}

	public function createMoviesPreviewVideo() {
		$entitiesArray = EntityProvider::getMoviesEntities($this->conn, null, 1);

		if(sizeof($entitiesArray) == 0) {
			ErrorMessage::show("No movies to display");
		}

		return $this->createPreviewVideo($entitiesArray[0]);
	}

	public function createCategoryPreviewVideo($categoryId) {
		$entitiesArray = EntityProvider::getEntities($this->conn, $categoryId, 1);

		if(sizeof($entitiesArray) == 0) {
			ErrorMessage::show("No tv shows to display");
		}

		return $this->createPreviewVideo($entitiesArray[0]);
	}

	public function createPreviewVideo($entity) {
		if($entity == null) {
			$entity = $this->getRandomEntity();

			$id = $entity->getID();
			$name = $entity->getName();
			$preview = $entity->getPreview();
			$thumbnail = $entity->getThumbnail();

			$videoId = VideoProvider::getEntityVideoForUser($this->conn, $id, $this->username);
			$video = new Video($this->conn, $videoId);

			$isInProgress = $video->isInProgress($this->username);
			$playButtonText = $isInProgress ? "Continue Watching" : "Play";

			$seasonEpisode = $video->getSeasonAndEpisode();
			$subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>";

			return "<div class='previewContainer'>

						<img src='$thumbnail' class='previewImage' hidden />

						<video autoplay muted class='previewVideo' onended='previewEnded()'>
							<source src='$preview' type='video/mp4' />
						</video>

						<div class='previewOverlay'>

							<div class='mainDetails'>

								<h3>$name</h3>
								$subHeading
								<div class='buttons'>

									<button onclick='watchVideo($videoId)'><i class='fa fa-play'></i> $playButtonText</button>
									<button onclick='volumeToggle(this)'><i class='fa fa-volume-off'></i></button>
								</div>

							</div>

						</div>

					</div>";	
		}
	}

	public function createEntityProvider($entity) {
		$id = $entity->getId();
		$thumbnail = $entity->getThumbnail();
		$name = $entity->getName();

		return "<a href='entity.php?id=$id'>

					<div class='previewContainer small'>
						<img src='$thumbnail' title='$name' />
					</div>

				</a>";
	}

	private function getRandomEntity() {
		$entity = EntityProvider::getEntities($this->conn, null, 1);
		return $entity[0];
	}


}


?>