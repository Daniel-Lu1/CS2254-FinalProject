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
<body class="main">
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
	<div class="home"> 
		<p id="title">The Cookbook</p><br>
		<div id="h-box">
			<form method="get" id="search" action="results.php">
				<input type="text" name="name" id="name" placeholder="Enter a keyword">
				<input type="submit" class="button" name="submit" id="submit" value="Search">
			</form>
			<br>
			<button onclick="location.href ='adv.php'" type="button" class="button">Advanced Search</button>
		</div>
	</div>
</body>
</html>