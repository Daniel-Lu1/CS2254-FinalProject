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
	<form class="containter" method="get" action="results.php">
		<div>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label">Keyword(s)<i class="req">*</i>: </label>
				<div class="col-xs-3">
					<input class="form-control" type="text" name="key" placeholder="Enter a keyword" required><br>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label">Number of Results: </label>
				<div class="col-xs-3">	
					<input class="form-control" type="text" name="num" placeholder="Enter a maximum number of results to show"><br>
				</div>
			</div>
			<div class="form-group row">	
				<label class="col-sm-2">Select a diet label: </label><br>
				<div class="col-sm-10">
					<div class="radio">
						<label>
							<input type="radio" name="diet" value="balanced">Balanced
						</label><br>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="diet" value="high-protein">High-Protein
						</label><br>
					</div>
					<div class="radio">		
						<label>
							<input type="radio" name="diet" value="high-fiber">High-Fiber
						</label><br>
					</div>
					<div class="radio">		
						<label>
							<input type="radio" name="diet" value="low-fat">Low-Fat
						</label><br>
					</div>
					<div class="radio">		
						<label>
							<input type="radio" name="diet" value="low-carb">Low-Carb
						</label><br>
					</div>
					<div class="radio">		
						<label>
							<input type="radio" name="diet" value="low-sodium">Low-Sodium
						</label><br>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2">Select a health label:</label><br>
				<div class="col-sm-10">
					<div class="radio">
						<label>
							<input type="radio" name="health" value="vegan">Vegan
						</label><br>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="health" value="vegetarian">Vegetarian
						</label><br>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="health" value="paleo">Paleo
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="diary-free">Dairy-Free
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="gluten-free">Gluten-Free
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="wheat-free">Wheat-Free
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="fat-free">Fat-Free
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="low-sugar">Low-Sugar
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="egg-free">Egg-Free
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="peanut-free">Peanut-Free
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="tree-nut-free">Tree-nut-free
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="soy-free">Soy-Free
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="fish-free">Fish-Free
						</label><br>
					</div>
					<div class="radio">	
						<label>
							<input type="radio" name="health" value="shellfish-free">Shellfish-Free
						</label><br>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 form-control-label">Calorie Range: </label><br>
				<div class="col-xs-3">
					<label>Low</label><input class="form-control" type="text" name="low" placeholder="0"><br>
					<label>High</label><input class="form-control" type="text" name="high" placeholder="10000"><br>
				</div>
			</div>
			<div class="form-group row">
				<input class="btn btn-secondary" type="submit" name="advsub" value="Search">
			</div>
		</div>
	</form>
</body>
</html>