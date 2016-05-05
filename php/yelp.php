<?php
error_reporting(0);
?>
<!DOCTYPE html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
		<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <a class="navbar-brand" href="http://cscilab.bc.edu/~borisenk/test/index.php">Cookbook</a>
	    </div>
		<form class="navbar-form navbar-left" role="search" method="get" id="yelp" action="yelp.php">
			Find: <input type="text" class="form-control" name="food" id="foodtype" 
				<?php 
					if(isset($_GET['submit'])){ 
						echo 'value="'.$_GET['food'].'"';
					} 
				?>
			>
			Near: <input type="text" class="form-control" name="location" 
				<?php 
					if(isset($_GET['submit'])){ 
						echo 'value="'.$_GET['location'].'"';
					} 
				?>
			>
			<input type="submit" class="btn btn-default" name="submit" id="submit" value="Go!">
		</form>
		 <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	    <?php
				if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
					if($_SESSION['username'] == 'chefsidekick@yahoo.com'){
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'admin2.php\';" id="adminpage">Admin Page</button>';
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'displayRecipes.php\';" id="display">Show Saved Recipes</button>';
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'logout.php\';" id="logout">Log out</button>';
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'https://www.yelp.com\';" id="yelpbutton"><img src="yelpimg/yelplogo.jpg"></button>';
					}
					else{
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'displayRecipes.php\';" id="display">Show Saved Recipes</button>';
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'logout.php\';" id="logout">Log out</button>';
					echo '<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'https://www.yelp.com\';" id="yelpbutton"><img src="yelpimg/yelplogo.jpg"></button>';
					}
				}
				else{
				echo '
			<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'signup.html\';" id="signup">Sign up</button>
			<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'login.html\';" id="login">Sign in</button>
			<button class="btn btn-default navbar-btn navbar-nav navbar-right" onclick="location.href = \'https://www.yelp.com\';" id="yelpbutton" style="padding:0px;"><img style="width:auto;height:33px;" src="yelpimg/yelplogo.jpg"></button>';
			}
			?>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
	<?php

require_once('OAuth.php');

$CONSUMER_KEY = 'RyxTDBtjVungJaJTMyip3A';
$CONSUMER_SECRET = 'JWT1MwyqYczMafwdq09fBQrM6J8';
$TOKEN = 'D3bl5jWz-GacPo8XuG-o08vyR98DsGQ_';
$TOKEN_SECRET = 'ZfLslpP3hVBgv7bxWdHYFBr1fbo';
$API_HOST = 'api.yelp.com';
$DEFAULT_TERM = 'food';
$DEFAULT_LOCATION = 'Boston College, MA';
$SEARCH_LIMIT = 20;
$SEARCH_PATH = '/v2/search/';
$BUSINESS_PATH = '/v2/business/';

function request($host, $path) {
    $unsigned_url = "https://" . $host . $path;
    // Token object built using the OAuth library
    $token = new OAuthToken($GLOBALS['TOKEN'], $GLOBALS['TOKEN_SECRET']);
    // Consumer object built using the OAuth library
    $consumer = new OAuthConsumer($GLOBALS['CONSUMER_KEY'], $GLOBALS['CONSUMER_SECRET']);

    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();
    $oauthrequest = OAuthRequest::from_consumer_and_token(
        $consumer, 
        $token, 
        'GET', 
        $unsigned_url
    );
    
    $oauthrequest->sign_request($signature_method, $consumer, $token);
 
    $signed_url = $oauthrequest->to_url();
    
    try {
        $ch = curl_init($signed_url);
        if (FALSE === $ch)
            throw new Exception('Failed to initialize');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        if (FALSE === $data)
            throw new Exception(curl_error($ch), curl_errno($ch));
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($data, $http_status);
        curl_close($ch);
    } catch(Exception $e) {
       
    }
    
    return $data;
}
/*
 Query the Search API by a search term and location 
 */
function search($term, $location) {
    $url_params = array();
    
    $url_params['term'] = $term ?: $GLOBALS['DEFAULT_TERM'];
    $url_params['location'] = $location?: $GLOBALS['DEFAULT_LOCATION'];
    $url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];
    $search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);
    
    return request($GLOBALS['API_HOST'], $search_path);
}
/*
 Query the Business API by business_id
 */
function get_business($business_id) {
    $business_path = $GLOBALS['BUSINESS_PATH'] . urlencode($business_id);
    
    return request($GLOBALS['API_HOST'], $business_path);
}
/*
 Queries the API by the input values from the user 
 */
function query_api($term, $location) {     
    $response = json_decode(search($term, $location));
    echo '<div class="datagrid">
		<table id="results"><thead><tr><th align=\"center\">Business Name</th><th align=\"center\">Picture</th><th align=\"center\">Rating</th><th align=\"center\">Number of Reviews</th><th align=\"center\" style="width:170px;">Phone Number</th><th align=\"center\">Address</th></tr></thead><tbody>';
    for ($i = 0; $i < 20; $i++){
    $business_name = $response->businesses[$i]->name;
    $business_pic = $response->businesses[$i]->image_url;
    $business_rating = $response->businesses[$i]->rating;
    $business_reviews = $response->businesses[$i]->review_count;
    $business_phone = $response->businesses[$i]->display_phone;
    $business_addr = ($response->businesses[$i]->location->display_address[0]).', '.($response->businesses[$i]->location->display_address[1]);
    echo '<tr><th>'.$business_name.'</th><th>'.'<img src="'.$business_pic.'"></th><th>'.'<img src="yelpimg/stars'.$business_rating.'.jpg" style="height:19.33px;width:107.667px;"></th><th>'.$business_reviews.'</th><th>'.$business_phone.'</th><th>'.$business_addr.'</th><th><tr>';
    }
    echo '</tbody></table>
    </div>';
}
?>
	
	<?php
		if(isset($_GET['submit'])) { 
			query_api($_GET['food'], $_GET['location']);
	 } ?>
	
</body>
</html>
