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
					if(isset($_GET['advsub'])){
						echo 'value="'.$_GET['key'].'"';
					}
				?>
			>
			<input type="submit" name="submit" id="submit" value="Search">
		</form>
	</div>
	<div class="datagrid">
		<table id="results"><tr><th>Recipe Name</th><th>Summary</th><th>Calories</th><th>Ingredients</th></tr></table>
	</div>
	<script>
		$(document).ready(function(){
			$("#submit").click(function(){
				simple();
			})
		});
		function simple(){
			var request = $.ajax({
				url: "https://api.edamam.com/search",
				jsonp: "callback",
				dataType: "jsonp",
				data: {
					q: $("#name").val(),
					//from:0,
					//to:100,
					//calories: "gte 250, lte 500",
					api_id:  "61496f24",
					api_key: "df682debbdd8c22dd3776834d4b83a41"
				},
				success: function(callback){
					$("#results").html("");
					$("#results").append("<thead><tr><th>Recipe Name</th><th>Calories</th><th>Ingredients</th></tr></thead><tbody>");
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
					$("#results").append("</tbody>");
				}
			});			
		};
		function adv(){
			var $_GET = <?php echo json_encode($_GET); ?>;
			var key = $_GET['key'];
			if(!$_GET['num']){
				var num = 10;
			}else{
				var num = $_GET['num'];
			}
			if(!$_GET['diet']){
				var diet = null;
			}else{
				var diet = $_GET['diet'];
			}
			if(!$_GET['health']){
				var health = null;
			}else{
				var health = $_GET['health'];
			}
			if(!$_GET['low']){
				var low = 0;
			}else{
				var low = $_GET['low'];
			}
			if(!$_GET['high']){
				var high = 100000;
			}else{
				var high = $_GET['high'];
			}
			var cal = "gte " + low + "," + "lte " + high;
			console.log($_GET['key']+" "+$_GET['num']+" "+$_GET['diet']+" "+$_GET['health']+" "+$_GET['low']+" "+$_GET['high']+" "+cal);
			if(diet!=null && health!=null){
				var request = $.ajax({
					url: "https://api.edamam.com/search",
					jsonp: "callback",
					dataType: "jsonp",
					data: {
						q: key,
						from: 0,
						to: num,
						diet: diet,
						health: health,
						calories: cal,
						api_id:  "61496f24",
						api_key: "df682debbdd8c22dd3776834d4b83a41"
					},
					success: function(callback){
						$("#results").html("");
						$("#results").append("<thead><tr><th>Recipe Name</th><th>Calories</th><th>Ingredients</th></tr></thead><tbody>");
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
						$("#results").append("</tbody>");
					}
				});
			}else if(diet==null && health!=null){
				var request = $.ajax({
					url: "https://api.edamam.com/search",
					jsonp: "callback",
					dataType: "jsonp",
					data: {
						q: key,
						from: 0,
						to: num,
						health: health,
						calories: cal,
						api_id:  "61496f24",
						api_key: "df682debbdd8c22dd3776834d4b83a41"
					},
					success: function(callback){
						$("#results").html("");
						$("#results").append("<thead><tr><th>Recipe Name</th><th>Calories</th><th>Ingredients</th></tr></thead><tbody>");
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
						$("#results").append("</tbody>");
					}
				});
			}else if(diet!=null && health==null){
				var request = $.ajax({
					url: "https://api.edamam.com/search",
					jsonp: "callback",
					dataType: "jsonp",
					data: {
						q: key,
						from: 0,
						to: num,
						diet: diet,
						calories: cal,
						api_id:  "61496f24",
						api_key: "df682debbdd8c22dd3776834d4b83a41"
					},
					success: function(callback){
						$("#results").html("");
						$("#results").append("<thead><tr><th>Recipe Name</th><th>Calories</th><th>Ingredients</th></tr></thead><tbody>");
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
						$("#results").append("</tbody>");
					}
				});
			}else{
				var request = $.ajax({
					url: "https://api.edamam.com/search",
					jsonp: "callback",
					dataType: "jsonp",
					data: {
						q: key,
						from: 0,
						to: num,
						calories: cal,
						api_id:  "61496f24",
						api_key: "df682debbdd8c22dd3776834d4b83a41"
					},
					success: function(callback){
						$("#results").html("");
						$("#results").append("<thead><tr><th>Recipe Name</th><th>Calories</th><th>Ingredients</th></tr></thead><tbody>");
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
						$("#results").append("</tbody>");
					}
				});
			}
		};
	</script>
	<?php
		if(isset($_GET['submit'])) { ?>
			<script>simple();</script>
	<?php }
		if(isset($_GET['advsub'])) { ?>
			<script>adv();</script>
	<?php } ?>
</body>
</html>