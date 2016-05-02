<!DOCTYPE php>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Club Home Page</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>

<div id="recipePhoto" name="recipePhoto">
	<div class="inner first"></div>
	<div class="inner second"></div>
	<div class="inner third"></div>
	<div class="inner fourth"></div>
	<div class="inner fifth"></div>
</div>


<?php

include("dbconn.php");

$recipeName = $_GET['recipe'];
echo '<script>
		$(document).ready(function(){
				search();
		});
		function search(){
			var request = $.ajax({
				url: "https://api.edamam.com/search",
				jsonp: "callback",
				dataType: "jsonp",
				data: {
					q: "' . $recipeName . '",
					from:0,
					to:1,
					//calories: "gte 250, lte 500",
					//diet: "balanced",
					api_id:  "61496f24",
					api_key: "df682debbdd8c22dd3776834d4b83a41"
				},
				success: function(callback){
						$("div.first").replaceWith("<img src=" + callback.hits[0].recipe.image + ">");
						$("div.second").replaceWith("<h1>" + callback.hits[0].recipe.label + "</h1>");
						$("div.third").replaceWith("<h1>Calories:" + callback.hits[0].recipe.calories + "</h1>");
						var len2 = callback.hits[0].recipe.ingredients.length;
						var s = "<li>";
						var c = "</li>";
						var str2 = "";
						for(j=0;j<len2;j++){
							var line = callback.hits[0].recipe.ingredients[j].text;
							var st = s.concat(line);
							var fin = st.concat(c);
							str2 = str2.concat(fin);
						};
						$("div.fourth").replaceWith("<h1>Ingredients:" + str2 + "</h1>");
						$("div.fifth").replaceWith("<h1>" + callback.hits[0].recipe.url + "</h1>");
				}
			});
		};
	</script>'

?>



</body>
</html>