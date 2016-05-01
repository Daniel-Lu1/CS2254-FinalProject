<!DOCTYPE html>
<html lang="en">
<head>
	<title>Mail Users</title>
</head>
<body>
	<h1>Mail Users</h1>
		<fieldset>
			<legend>Mail Your Chefs</legend>
			<form method="post" action="chefMail.php" name="MyMail">
			<label>Subject: </label><input type="text" name="subj" required><br>
			<label>Your Message: <br><label><textarea rows="5" cols="50" type="text" name="message" required></textarea><br>
			<button type="submit" name="go" class="submitbutton">Send Your Message</button>
			</form>
		</fieldset>
</body>
</html>