<?php
include('dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mail Chefs</title>
</head>
<body>
<?php
$subject = $_POST["subj"];
$message = $_POST["message"];

$dbc = connect_to_db("borisenk");
$query = "SELECT `email` FROM `CHEF`";
$result = perform_query($dbc, $query);
while($row = mysqli_fetch_row($result)){
mail($row[0],$subject,$message);
}
	
	echo '<h1>Your message has been sent!</h1>';
	@disconnect_from_db("borisenk", $result);
	}
?>
</body>
</html>