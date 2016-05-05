<?php
session_start();
?>

<!DOCTYPE php>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>The Cookbook</title>
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
<div id="recipeBody">
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
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'displayRecipes.php\';" id="display">Show Saved Recipes</button>';

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
<center>
<div id="recipePhoto" name="recipePhoto">
	<div class="inner first"></div>
	<div class="inner second"></div>
	<div class="inner third"></div>
	<div class="inner fourth"></div>
	<div class="inner fifth"></div>
</div>
<div id="sixth"></div>

<form method="post" action="saveRecipe.php" id="saveRecipeForm">
	<button class="button" type="submit" name="saveRecipeButton" id="saveRecipeButton">Save this Recipe!</button>
	<input type="hidden" value="" name="recipeNameHidden" id="recipeNameHidden">
</form>



<?php

include("dbconn.php");

$recipeURI = $_GET['recipe'];
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
					q: "' . $recipeURI . '",
					from:0,
					to:1,
					//calories: "gte 250, lte 500",
					//diet: "balanced",
					api_id:  "61496f24",
					api_key: "df682debbdd8c22dd3776834d4b83a41"
				},
				success: function(callback){
						$("div.first").replaceWith("<img src=" + callback.hits[0].recipe.image + ">");
						$("div.second").replaceWith("<h3>" + callback.hits[0].recipe.label + "</h3><br>");
						var cal = callback.hits[0].recipe.calories;
						var cal2 = parseInt(cal);
						$("div.third").replaceWith("<h4>Calories: " + cal2 + "</h4><br>");
						var len2 = callback.hits[0].recipe.ingredients.length;
						var s = "<li class=\'listItem\'>";
						var c = "</li>";
						var str2 = "";
						for(j=0;j<len2;j++){
							var line = callback.hits[0].recipe.ingredients[j].text;
							var st = s.concat(line);
							var fin = st.concat(c);
							str2 = str2.concat(fin);
						};
						$("div.fourth").replaceWith("<h4>Ingredients:</h4><br><div class=\'containerX\'><ul id=\'list-unstyled\'" + str2 + "</ul></div>");
						$("#recipeNameHidden").val(callback.hits[0].recipe.label);
						$(document.body).append("<center><iframe class=' . '\'iframe\'' . ' src=" + callback.hits[0].recipe.url + "></iframe></div></center>");
				}
			});
		};
	</script>'

?>
</center>
</body>
</html>
