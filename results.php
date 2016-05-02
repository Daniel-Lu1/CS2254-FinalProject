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
	<div>
		<table id="results"><tr><th>Recipe Name</th><th>Summary</th><th>Calories</th><th>Ingredients</th></tr></table>
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
					$("#results").html("");
					$("#results").append("<tr><th>Recipe Name</th><th>Calories</th><th>Ingredients</th></tr>");
					var len = callback.hits.length;
					for(i=0;i<len;i++){
						var str1 = "<tr><td>"+callback.hits[i].recipe.label+"</td><td>"+callback.hits[i].recipe.calories+"</td><td><ul>";
						var len2 = callback.hits[i].recipe.ingredients.length;
						var s = "<li>";
						var c = "</li>";
						var str2 = "";
						for(j=0;j<len2;j++){
							var line = callback.hits[i].recipe.ingredients[j].text;
							var st = s.concat(line);
							var fin = st.concat(c);
							str2 = str2.concat(fin);
						};
						var str3 = "</ul></td></tr>";
						var str = str1.concat(str2,str3);
						$("#results").append(str);
					};
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