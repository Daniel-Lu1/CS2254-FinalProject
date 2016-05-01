<?php 
	include('dbconn.php');

		$userID = $_GET['userData'];

		
		$database = connect_to_db("borisenk");
		$query = "DELETE FROM `Chef` WHERE `id`='".$userID."'";
		$result = perform_query($database, $query);
		disconnect_from_db($database, $result);
		header('Location: http://cscilab.bc.edu/~waalkes/cooking/admin2.php');
