<!DOCTYPE php>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Mexican Food Website</title>
	<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/cookingCSS.css">
<body>

<h1>Mexican Food</h1>


<fieldset id="registerFieldset">
	<legend>Become a Chef!</legend>
	<form name="registerChefForm" id="registerChefForm" method="POST" action="registerChef.php" onsubmit="return validateForm();">
		Name <br>
		<input type="text" name="firstName" id="firstName" placeholder="First" />
		<input type="text" name="lastName" id="lastName" placeholder="Last" />
		<div id="nameWrong" class="wrong"></div>
		<br> 
		Email <br>
		<input type="text" name="registerEmail" id="registerEmail" placeholder="example@website.com" />
		<div id="emailWrong" class="wrong"></div>
		<br>
		Create Password <br>
		<input type="password" name="registerPassword" id="registerPassword" />
		<div id="password1Wrong" class="wrong"></div>
		<br>
		Confirm Password <br>
		<input type="password" name="registerPassword2" id="registerPassword2" />
		<div id="password2Wrong" class="wrong"></div>
		<div id="passwordWrong" class="wrong"></div>
		<br>
		<input type="submit" name="registerChefSubmit" value="Become a Chef!"/>
	</form>
</fieldset>

</body>
</html>

<script type="text/javascript">	

function validateForm(){
	
	var firstName = document.forms["registerChefForm"]["firstName"].value;
	var lastName  = document.forms["registerChefForm"]["lastName"].value;
	var email     = document.forms["registerChefForm"]["registerEmail"].value;
	var password1 = document.forms["registerChefForm"]["registerPassword"].value;
	var password2 = document.forms["registerChefForm"]["registerPassword2"].value;
	var status    = true;
	var filter    = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if( (firstName=="") || (lastName=="") ){
		var firstNameWrong = document.getElementById("nameWrong");
		nameWrong.innerHTML = "Add your name!";
		status = false;
	}
	if (!filter.test(email)){
		var emailWrong = document.getElementById("emailWrong");
		emailWrong.innerHTML = "Enter a valid email!";
		status = false;
	}
	if (password1 != password2){
		var passwordWrong = document.getElementById("passwordWrong");
		passwordWrong.innerHTML = "Passwords do not match!";
		status = false;
	}
	if (password1.length < 5){
		var passwordWrong = document.getElementById("passwordWrong");
		passwordWrong.innerHTML = "Choose a longer password!";
		status = false;
	}

	return status;
}

</script>

<script type="text/javascript">

</script>

<?php 

//ID: 61496f24
//Key: df682debbdd8c22dd3776834d4b83a41

?>
