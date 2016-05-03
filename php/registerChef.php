<!DOCTYPE php>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Club Home Page</title>
</head>
<body>

<?php

include("dbconn.php");

if (isset($_POST['registerChefSubmit'])){
		
	$firstName = $_POST["firstName"];
	$lastName = $_POST["lastName"];
	$email = $_POST["registerEmail"];
	$password = $_POST["registerPassword"];
	$encryptedPassword = sha1($password);

	$dbc = connect_to_db("borisenk");
	
	$checkEmailQuery = "SELECT * FROM `Chef` WHERE `email` = '". $email ."'";
	$insertQuery = "INSERT INTO `Chef` (firstName, lastName, email, password) VALUES ('".$firstName."','".$lastName."','".$email."','".$encryptedPassword."')";

	$emailQResult = perform_query($dbc, $checkEmailQuery);

	if (mysqli_num_rows($emailQResult) == 0){
		$insertResult = perform_query($dbc, $insertQuery);
		disconnect_from_db($dbc, $insertResult);
		correct();
	}
	else{
		echo '<h1>tru3</h1>';
		incorrect();
	}
}

?>

</body>
</html>

<?php
function incorrect(){
	echo '<a href="http://cscilab.bc.edu/~waalkes/cooking/cooking.php"><h1>You\'re already registered! Click here to be redirected and log in!</h1></a>';
}

function correct(){
	echo '<a href="http://cscilab.bc.edu/~waalkes/cooking/cooking.php"><h1>Registered! Click here to be redirected back to the page!</h1></a>';
}

?>