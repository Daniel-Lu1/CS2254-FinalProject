<?php 
session_start();
?>

<!DOCTYPE php>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Saved Recipes</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

<?php

include("dbconn.php");

if(isset($_POST['returnToSearch'])){
	echo '<script type="text/javascript">
	window.history.go(-2);
	</script>';
}

if (isset($_POST['saveRecipeButton'])){
	$recipeName = $_POST['recipeNameHidden'];
	$username = $_SESSION["username"];
		
	$dbc = connect_to_db("borisenk");
	//Query to get userID
	$idQuery = "SELECT id FROM `Chef` WHERE `email` = '". $username ."'";
	$idResult = perform_query($dbc, $idQuery);
	$row = mysqli_fetch_row($idResult);
	$userID = $row[0];

	/*
	if (mysqli_num_rows($idResult) == 0){
		disconnect_from_db($dbc, $userID);
		correct($recipeName); //not logged in 
	}
	*/

		$recipeNumQ = "SELECT * FROM `A_RU` WHERE `recipe_id` = '". $recipeName ."' AND `user_id` = '". $userID ."'";
		$numQ = perform_query($dbc, $recipeNumQ);

		if (mysqli_num_rows($numQ) == 0){
			//Query to add recipe using userID and recipeName
			$addQuery = "INSERT into A_RU(user_id, recipe_id) VALUES ('". $userID . "','". $recipeName . "')";
			$addResult = perform_query($dbc, $addQuery);
			disconnect_from_db($dbc, $addResult);
		}
			redirect();
	}

?>

</body>
</html>

<?php

function redirect(){
	echo '<script type="text/javascript">
	window.history.go(-1);
	</script>';
}
?>