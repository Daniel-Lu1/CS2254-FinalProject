<?php
session_start();
?>
<!DOCTYPE html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <a class="navbar-brand" href="http://cscilab.bc.edu/~borisenk/test/index.php">Cookbook</a>
	    </div>
		<form class="navbar-form navbar-left" role="search" method="get" id="search" action="results.php">
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter a keyword"
          	<?php 
				if(isset($_GET['submit'])){ 
					echo 'value="'.$_GET['name'].'"';
				} 
				if(isset($_GET['advsub'])){
					echo 'value="'.$_GET['key'].'"';
				}
			?>
          required>
          <input type="submit" class="btn btn-default" name="submit" id="submit" value="Search">
          <button onclick="location.href ='adv.php'" type="button" class="btn btn-default">Advanced Search</button>
    	</form>
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <?php
				if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
					if($_SESSION['username'] == 'chefsidekick@yahoo.com'){
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'admin2.php\';" id="adminpage">Admin Page</button>';
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'displayrecipes.php\';" id="display">Show Saved Recipes</button>';
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'logout.php\';" id="logout">Log out</button>';
					}
					else{
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'http://cscilab.bc.edu/~waalkes/cooking/displayRecipes.php\';" id="display">Show Saved Recipes</button>';
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'logout.php\';" id="logout">Log out</button>';
					}
				}
				else{
				echo '
			<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'signup.html\';" id="signup">Sign up</button>
			<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'login.html\';" id="login">Sign in</button>';
			}
			?>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	<div class="datagrid">
		<table id="results"></table>
		<p id="noresults">Whoops! Looks like your search didn't come up with any recipes. Try again!</p>
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
					api_id:  "61496f24",
					api_key: "df682debbdd8c22dd3776834d4b83a41"
				},
				success: function(callback){
					var len = callback.hits.length;
					if(len==0){
						$(".datagrid").hide();
						$("#noresults").show();
					}else{
						$("#noresults").hide();
						$(".datagrid").show();
						$("#results").append("<thead><tr><th align=\"center\">Image</th><th align=\"center\">Recipe Name</th><th align=\"center\">Calories</th><th align=\"center\">Ingredients</th></tr></thead><tbody>");
						for(i=0;i<len;i++){
							var str1 = "<tr><td class=\"hiddenURI\" style=\"display:none\">" + callback.hits[i].recipe.label + "</td><td><img src=\"" + callback.hits[i].recipe.image + "\" alt=\"foodpic\"></td><td>"+callback.hits[i].recipe.label+"</td><td>"+callback.hits[i].recipe.calories.toFixed(2)+"</td><td><ul>";
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
			var params = {
				q: key,
				from: 0,
				to: num,
				calories: cal,
				api_id:  "61496f24",
				api_key: "df682debbdd8c22dd3776834d4b83a41"
			};
			if(diet!=null && health!=null){
				params.diet = diet;
				params.health = health;
			}else if(diet==null && health!=null)
				params.health = health;
			else if(diet!=null && health==null)
				params.diet = diet;
			var request = $.ajax({
					url: "https://api.edamam.com/search",
					jsonp: "callback",
					dataType: "jsonp",
					data: params,
					success: function(callback){
						var len = callback.hits.length;
						if(len==0){
							$("#results").hide();
							$("#noresults").show();
						}else{
							$("#noresults").hide();
							$("#results").append("<thead><tr><th align=\"center\">Image</th><th align=\"center\">Recipe Name</th><th align=\"center\">Calories</th><th align=\"center\">Ingredients</th></tr></thead><tbody>");
							for(i=0;i<len;i++){
								var str1 = "<tr><td><img src=\"" + callback.hits[i].recipe.image + "\" alt=\"foodpic\"></td><td class=\"hiddenURI\" style=\"display:none\">" + callback.hits[i].recipe.label + "</td><td>"+callback.hits[i].recipe.label+"</td><td>"+callback.hits[i].recipe.calories.toFixed(2)+"</td><td><ul>";
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
					}
				});
		};
	</script>
	<?php
		if(isset($_GET['submit'])) { ?>
			<script>simple();</script>
	<?php }
		if(isset($_GET['advsub'])) { ?>
			<script>adv();</script>
	<?php } ?>
	
<script type="text/javascript">
$(document).on("click", "#results tr", function(e) {
        var recipeURI = $(this).find(".hiddenURI").html();
        window.location.href = "http://cscilab.bc.edu/~waalkes/cooking/recipe.php?recipe=" + recipeURI;
});
</script>

</body>
</html>