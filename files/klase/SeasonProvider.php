<?php  

class SeasonProvider {
	private $conn;
	private $username;

	function __construct($conn, $username) {
		$this->conn = $conn;
		$this->username = $username;
	}

	public function create($entity) {
		$seasons = $entity->getSeasons();

		if(sizeof($seasons) == 0) {
			return;
		}

		$seasonHtml = "";

		foreach ($seasons as $season) {
			$seasonNumber = $season->getSeasonNumber();

			$videosHtml = "";

			foreach ($season->getVideos() as $video) {
				$videosHtml .= $this->createVideoSquare($video);
			}

			$seasonHtml .= "<div class='season'>
								<h3>Season $seasonNumber</h3>

								<div class='videos'>
									$videosHtml
								</div>
							</div>";
		}
		return $seasonHtml;
	}

	private function createVideoSquare($video) {
		$id = $video->getId();
		$description = $video->getDescription();
		$name = $video->getTitle();
		$thumbnail = $video->getThumbnail();
		$episodeNumber = $video->getEpisodeNumber();
		$hasSeen = $video->hasSeen($this->username) ? "<i class='fa fa-check-circle seen'></i>" : "";

		return "<a href='watch.php?id=$id'>
					<div class='episodeContainer'>
						<div class='contents'>
							<img src='$thumbnail'>

							<div class='videoInfo'>
								<h3>$episodeNumber. $name</h3>
								<span>$description</span>
							</div>
							$hasSeen
						</div>
					</div>

				</a>";	
	}
}
?>