<?php 
session_start();
?>

<!DOCTYPE php>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<meta charset="utf-8" />
	<title>Saved Recipes</title>
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
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'logout.php\';" id="logout">Log out</button>';
					}
					else{
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
		<table id="results"><tr><th>Recipe Name</th><th>Summary</th><th>Calories</th><th>Ingredients</th></tr></table>
</div>

<?php

include("dbconn.php");

$username = $_SESSION["username"];
	
$dbc = connect_to_db("borisenk");
//Query to get userID
$idQuery = "SELECT id FROM `Chef` WHERE `email` = \"". $username . "\"";
$idResult = perform_query($dbc, $idQuery);

$row = mysqli_fetch_row($idResult);
$userID = $row[0];

$recipeQ = "SELECT `recipe_id` FROM `A_RU` WHERE `user_id` = \"". $userID . "\"";
$recipeResult = perform_query($dbc, $recipeQ);
$numRows = mysqli_num_rows($recipeResult);
//$row2 = mysql_fetch_array($recipeResult);
$myArray = array();

while ($row = mysqli_fetch_row($recipeResult)){
	$myArray[] = $row;
}

disconnect_from_db($dbc, $recipeResult)
?>
	
<script type="text/javascript">

$(document).on("click", "#results tr", function(e) {

        var recipeURI = $(this).find(".hiddenURI").html();
        window.location.href = "http://cscilab.bc.edu/~waalkes/cooking/recipe.php?recipe=" + recipeURI;

});

$(document).ready( function(){
	//search("Chicken");
	$("#results").html("");
		$("#results").append("<thead><tr><th>Image</th><th>Recipe</th><th>Calories</th><th>Ingredients</th></tr></thead><tbody>");
		var array = <?php echo json_encode($myArray); ?>;
		for (i=0; i < array.length; i++){
			search(array[i][0]);
		}
		$("#results").append("</tbody>");
});

</script>

</body>
</html>

<script>
		function search(searchVal){
			var request = $.ajax({
				url: "https://api.edamam.com/search",
				jsonp: "callback",
				dataType: "jsonp",
				data: {
					q: searchVal,
					//from:0,
					//to:100,
					//calories: "gte 250, lte 500",
					//diet: "balanced",
					api_id:  "61496f24",
					api_key: "df682debbdd8c22dd3776834d4b83a41"
				},
				success: function(callback){
						var str1 = "<tr><td class=\"hiddenURI\" style=\"display:none\">" + callback.hits[0].recipe.label + "</td><td><img src=\"" + callback.hits[0].recipe.image + "\" alt=\"foodpic\"></td><td>"+callback.hits[0].recipe.label+"</td><td>"+callback.hits[0].recipe.calories+"</td><td><ul>";
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
						var str3 = "</ul></td></tr>";
						var str = str1.concat(str2,str3);
						$("#results").append(str);
				}
			});
		};
</script>
