<?php
session_start();
?>
<!DOCTYPE html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div id="home">
		<p id="title">The Cookbook</p><br>
		<div id="h-box">
			<form method="get" id="search" action="results.php">
				<input type="text" name="name" id="name" placeholder="Enter a keyword...">
				<input type="submit" name="submit" id="submit" value="Search">
			</form>
			<br>
			<form method="post" action="adv.php">
				<input type="submit" id="redirect" value="Advanced Search">
			</form>
		</div>
		<div class="userbuttons">
			<?php
				if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
				echo '<button onclick="location.href = \'logout.php\';" id="logout">Log out</button>';
				}
				else{
				echo '
			<button onclick="location.href = \'signup.html\';" id="signup">Sign up</button>
			<button onclick="location.href = \'login.html\';" id="login">Login</button>';
			}
			?>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$("#adv").click(function(){
			})
		})
	</script>
</body>
</html>
