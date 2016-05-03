<?php
include("dbconn.php");
$dbc = connect_to_db("borisenk");
$username=$_POST['email']; 
$password=$_POST['password']; 

/*$username = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);*/

$query = "SELECT * FROM `Chef` WHERE `email` = '".$username."'";
$result = perform_query($dbc, $query);
if (mysqli_num_rows($result)==1){
session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    header("Location: index.php");
	exit();
}
else{
echo '<h1>Incorrect Login Information</h1>';
echo '<a href="http://cscilab.bc.edu/~ludg/finalproject/login.html">Click here to try again.</a>';
}
/*In PHP file with the table displayed, 
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo the table that has the save features for members. because this is for members that are logged in. 
} else {
    echo normal table without member features. 
}*/
?>


