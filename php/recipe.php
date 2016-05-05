<?php
session_start();
?>
<!DOCTYPE php>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>The Cookbook</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <!--
	    <div class="navbar-header">
	      <a class="navbar-brand" href="http://cscilab.bc.edu/~borisenk/test/index.php">Cookbook</a>
	    </div>
		-->

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
	
<div id="recipePhoto" name="recipePhoto">
	<div class="inner first"></div>
	<div class="inner second"></div>
	<div class="inner third"></div>
	<div class="inner fourth"></div>
	<div class="inner fifth"></div>
</div>
<br>
<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
echo '
<form method="post" action="saveRecipe.php" id="saveRecipeForm">
	<input type="submit" name="saveRecipeButton" id="saveRecipeButton" value="Save this Recipe!">
	<input type="hidden" name="recipeNameHidden" id="recipeNameHidden">
	<input type="submit" name="returnToSearch" id="returnToSearch" value="Return to Search!">
</form>';
}
?>

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
						$(document.body).append("<iframe class=' . '\'iframe\'' . ' src=" + callback.hits[0].recipe.url + "></iframe>");
				}
			});
		};
	</script>'
?>



</body>
</html>
