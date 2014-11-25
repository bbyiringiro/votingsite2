<?php
session_start(); //Session should always be active

$app_id				= '1505091206437296';  //localhost
$app_secret 		= 'a5d5807d321ec51fe8f373e3981b49cf';
$redirect_url 		= 'http://localhost/graph/'; //FB redirects to this page with a code
//MySqli details for saving user details
$mysql_host			= 'localhost';
$mysql_username		= 'root';
$mysql_password		= '';
$mysql_db_name		= 'graph';

require_once __DIR__ . "/facebook-php-sdk-v4-4.0-dev/autoload.php"; //include autoload from SDK folder

//import required class to the current scope
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\Entities\AccessToken;
use Facebook\GraphUser;

FacebookSession::setDefaultApplication($app_id , $app_secret);
$helper = new FacebookRedirectLoginHelper($redirect_url);

try {
  $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
	die(" Error : " . $ex->getMessage());
} catch(\Exception $ex) {
	die(" Error : " . $ex->getMessage());
}


//if user wants to log out
if(isset($_GET["log-out"]) && $_GET["log-out"]==1){
	unset($_SESSION["fb_user_details"]);
	//session ver is set, redirect user 
	header("location: ". $redirect_url);
}

//Test normal login / logout with session

if ($session){ //if we have the FB session
	//get user data
	$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
	
	//save session var as array
	$_SESSION["fb_user_details"] = $user_profile->asArray(); 
	
	$user_id = ( isset( $_SESSION["fb_user_details"]["id"] ) )? $_SESSION["fb_user_details"]["id"] : "";
	$user_name = ( isset( $_SESSION["fb_user_details"]["name"] ) )? $_SESSION["fb_user_details"]["name"] : "";
	$user_email = ( isset( $_SESSION["fb_user_details"]["email"] ) )? $_SESSION["fb_user_details"]["email"] : "";
	
	###### connect to user table ########
	$mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_db_name);
	if ($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}
	
	//check user exist in table (using Facebook ID)
	$results = $mysqli->query("SELECT COUNT(*) FROM usertable WHERE fbid=".$user_id);
	$get_total_rows = $results->fetch_row();
	
	if(!$get_total_rows[0]){ //no user exist in table, create new user
		$insert_row = $mysqli->query("INSERT INTO usertable (fbid, fullname, email) VALUES(".$user_id.", '".$user_name."', '".$user_email."')");
	}
	
	
	
	
	//session ver is set, redirect user 
	header("location: ". $redirect_url);
	
}else{ 
	
	//session var is still there
	if(isset($_SESSION["fb_user_details"]))
	{
		print 'Hi '.$_SESSION["fb_user_details"]["name"].' you are logged in! [ <a href="?log-out=1">log-out</a> ] ';
		print '<pre>';
		print_r($_SESSION["fb_user_details"]);
		print '</pre>';
	}
	else
	{
		//display login url 
		$login_url = $helper->getLoginUrl( array( 'email', 'public_profile' ) );
		echo '<a href="'.$login_url.'">Login with Facebook</a>'; 
	}
}


