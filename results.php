<!DOCTYPE html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div>
		<form method="get" id="search">
			<input type="text" name="name" id="name" placeholder="Enter a keyword..." 
				<?php 
					if(isset($_GET['submit'])){ 
						echo 'value="'.$_GET['name'].'"';
					} 
				?>
			>
			<input type="submit" name="submit" id="submit" value="Search">
		</form>
	</div>
	<script>
		$(document).ready(function(){
			$("#submit").click(function(){
				search();
			})
		});
		function search(){
			var request = $.ajax({
				url: "https://api.edamam.com/search",
				jsonp: "callback",
				dataType: "jsonp",
				data: {
					q: $("#name").val(),
					//from:0,
					//to:100,
					//calories: "gte 250, lte 500",
					//diet: "balanced",
					api_id:  "61496f24",
					api_key: "df682debbdd8c22dd3776834d4b83a41"
				},
				success: function(callback){
					var len = callback.hits.length;
					for(i=0; i<len;i++)
						console.log(callback.hits[i].recipe.label);
					console.log(len);
				}
			});
		};
	</script>
	<?php
		if(isset($_GET['submit'])) { ?>
			<script>search();</script>
	<?php } ?>
</body>
</html>