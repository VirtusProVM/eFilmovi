<?php  

require_once("files/header.php");

?>


<div class="searchContainer">
	<input type="text" class="searchInput" placeholder="Search favorite movies, tv shows...">
</div>

<div class="results"></div>

<script>
	$(function() {
		var username = '<?php echo $userLoggedIn; ?>';
		var timer;

		$(".searchInput").keyup(function() {

			clearTimeout(timer);
			timer = setTimeout(function() {
				var val = $(".searchInput").val();

				if(val != "") {
					$.post("files/ajax/getSearchResult.php", { term : val, username: username}, function(data) {
						$(".results").html(data);
					})
				} else {
					$(".results").html("");
				}
			}, 500)
		})
	})
</script>