<?php

/*

Need to connect to correct database, not sure where we are hosting

*/

if (isset($_GET["regsiterChefSubmit"])){

	
	$database = @mysqli_connect("localhost", "waalkes", "79921620", "waalkes");
			
	$firstName = $_GET["firstName"];
	$lastName = $_GET["lastName"];
	$email = $_GET["registerEmail"];
	$password = $_GET["registerPassword1"];
	$encryptedPassword = sha1($password);
	$membershiptype = $_POST["membershiptype"];
	
	$checkEmailQuery = "SELECT * FROM `CHEF` WHERE `email`='".$email."'";
	$insertQuery = "INSERT INTO `CHEF` (first_name, last_name, email, password) VALUES ('".$firstName."','".$lastName."','".$email."','".$encryptedPassword."')";
	
	$emailQResult = perform_query($database, $checkEmailQuery);

	if (mysqli_num_rows($emailQResult)==0){
		mysqli_query($database, $insertQuery);
		mysqli_close($database);
	}
	else{
		incorrect();
	}
}