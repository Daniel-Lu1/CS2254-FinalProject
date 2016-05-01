<?php
	include('dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>Pageable Displays</title>
</head>
<body>
<h1>pagin</h1>

<?php
			// pagination support
			$itemsPerPage = 10;
	
			// figure out how many pages
			$pages = findpages($itemsPerPage);
			$start = findstart();
	
			createDataTable( $start, $itemsPerPage );
		?>


		<?php
			createPageLinks( $start, $pages, $itemsPerPage );
			if (isset($_GET['mailButton'])){
				mailForm();
			};

echo "<form method=\"get\">";
echo "<input type=\"submit\" name=\"mailButton\" id=\"mailButton\" value=\"Send Mail!\"/>";
echo "</form>";
?>
		
</body>
</html>

<?php
function createDataTable($start, $itemsPerPage){
	$qry = "SELECT `id`, `firstName`, `lastName`, `email` FROM `Chef` LIMIT $start, $itemsPerPage";
		
	echo "<table id=\"users\" class=\"table\">
				<tr>
					<th>Delete User</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
				</tr>\n";
				
				
	$dbc = connect_to_db('borisenk');
	$result = perform_query($dbc, $qry);
	while (@extract( mysqli_fetch_array( $result, MYSQLI_ASSOC ) )) {
		echo "	<tr>
					<td><form action=\"deleteUser.php\" method=\"get\"><input type=submit value=\"Delete\"</input><input type=\"hidden\" name=\"userData\" value=\"" . $id . "\"></input></form></td>
					<td>" . $firstName . "</td>
					<td>" . $lastName . "</td>
					<td>" . $email . "</td>
				</tr>\n";
	}
	echo "</table>\n";
}

function findpages($itemsPerPage){
	if (isset($_GET['p'])){
		// get it from the URL if we've already been here
		$pages=$_GET['p'];
	} else {
	
		// starting new, so get it from the database
		$qry="SELECT COUNT(email) as count from Chef;";
		
		$dbc = connect_to_db('borisenk');
		$result = perform_query($dbc, $qry);
		extract((array)mysqli_fetch_array($result, MYSQLI_ASSOC));
			
		if ($count > $itemsPerPage)
			$pages=ceil($count/$itemsPerPage);
		else
			$pages=1;
	}
	return $pages ;
}
function findstart(){
    // figure out where to start
	if (isset($_GET['s']))
		$start=$_GET['s'];
	else
		$start=0; // at the beginning
		
 	return $start ;
}
function createPageLinks($start, $pages, $itemsPerPage){
	
	// creating page links
	if ( $pages > 1 ) {
		
		// print Previous if not on the first page
		$currentPage = ( $start / $itemsPerPage ) + 1;
		if ($currentPage != 1){
			echo '<a href="admin2.php?s='.($start - $itemsPerPage) . 
														'&amp;p=' . $pages . '"> Previous </a>';
		}
		
		// print page numbers
		for ($i=1; $i <= $pages; $i++) {
				if ($i != $currentPage) {
					echo '<a href="admin2.php?s='. (( $itemsPerPage * ( $i - 1 ))) . 
												'&amp;p=' . $pages . '"> '. $i .'  </a>'."\n";
				}  else {
					echo $i . ' ';
				}
		}
	
		// print next if not on the last page
		if ( $currentPage != $pages ){
			echo '<a href="admin2.php?s='. ($start + $itemsPerPage) . '&amp;p=' . 
												$pages . '"> Next </a>';
		}
	}
}

function mailForm(){

	echo '<div id="emailFormDiv">
	<h1>Mail Users</h1>
		<fieldset>
			<legend>Mail Your Chefs</legend>
			<form method="post" action="chefMail.php" name="MyMail">
			<label>Subject: </label><input type="text" name="subj" required><br>
			<label>Your Message: <br><label><textarea rows="5" cols="50" type="text" name="message" required></textarea><br>
			<button type="submit" name="go" class="submitbutton">Send Your Message</button>
			</form>
		</fieldset>
		</div>';
}
?>