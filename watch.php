<?php  
$hideNav = true;
require_once("files/header.php");

if(!isset($_GET["id"])) {
	ErrorMessage::show("NO ID found!!!");
}

$user = new User($conn, $userLoggedIn);
if(!$user->isSubscribed()) {
	ErrorMessage::show("You must be subscribed to see this
						<a href='profile.php'>Click here to subscribe</a>");
}

$video = new Video($conn, $_GET["id"]);
$video->incrementViews();

$upNextVideo = VideoProvider::getUpNext($conn, $video);
?>

<div class="watchContainer">

	<div class="videoControls watchNav">
		<button onclick="goBack()"><i class="fa fa-arrow-left"></i></button>
		<h1><?php echo $video->getTitle(); ?></h1>
	</div>

	<div class="videoControls upNext" style="display: none;">
		<button onclick="restartVideo()"><i class="fa fa-repeat" aria-hidden="true"></i></button>

		<div class="upNextContainer">
			<h2>Up Next:</h2>
			<h3><?php echo $upNextVideo->getTitle(); ?></h3>
			<h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3>

			<button class="playNext" onclick="watchVideo(<?php echo $upNextVideo->getId(); ?>)"><i class="fa fa-play"></i>Play</button>
		</div>
	</div>
	
	<video autoplay controls onended="showUpNext()">
		<source src='<?php echo $video->getFilePath(); ?>' type="video/mp4">
	</video>
</div>

<script type="text/javascript">
	initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>