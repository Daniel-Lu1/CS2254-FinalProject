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
$headers = "From: ChefSidekick" . "\r\n" .
"CC: chefsidekick@yahoo.com";

$dbc = connect_to_db("borisenk");
$query = "SELECT `email` FROM `Chef`";
$result = perform_query($dbc, $query);
while($row = mysqli_fetch_row($result)){
mail($row[0],$subject,$message,$headers);
}
	
	echo '<h1>Your message has been sent!</h1>';
	@disconnect_from_db("borisenk", $result);
	
?>
</body>
</html>
