<?php
session_start(); //Session should always be active

$app_id				= '1505091206437296';  //localhost
$app_secret 		= 'a5d5807d321ec51fe8f373e3981b49cf';
$redirect_url 		= 'http://localhost/votingsite/'; //FB redirects to this page with a code
//MySqli details for saving user details
$mysql_host			= 'localhost';
$mysql_username		= 'root';
$mysql_password		= '';
$mysql_db_name		= 'votingsite';

require_once __DIR__ . "/fb/facebook-php-sdk-v4-4.0-dev/autoload.php"; //include autoload from SDK folder

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
	unset($_SESSION["fb_user"]);
    session_destroy();
	//session ver is set, redirect user 
	header("location: ". $redirect_url);
}

//Test normal login / logout with session

if ($session){ //if we have the FB session
	
	//get user data
	$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
	
	//save session var as array
	$_SESSION["fb_user"] = $user_profile->asArray(); 
	
		
	
	
	$isAdmin=true;
	if ($isAdmin){
		//photos on which our page is tagged in
		$request = new FacebookRequest(
				$session,
				'GET',
				'/706920989403844/photos/'
		);
		$response = $request->execute();
		$pics = $response->getGraphObject()->asArray();
	
		//photo which has been uploaded
		$request2 = new FacebookRequest(
				$session,
				'GET',
				'/706920989403844/photos/uploaded'
		);
		$response2 = $request2->execute();
		$pics2 = $response2->getGraphObject()->asArray();
	
	
	
	
	
		$_SESSION["photo1"]=$pics;
		$_SESSION["photo2"]=$pics2;
	}
	
	
	
	$user_id = ( isset( $_SESSION["fb_user"]["id"] ) )? $_SESSION["fb_user"]["id"] : "";
	$user_name = ( isset( $_SESSION["fb_user"]["name"] ) )? $_SESSION["fb_user"]["name"] : "";
	$user_email = ( isset( $_SESSION["fb_user"]["email"] ) )? $_SESSION["fb_user"]["email"] : "";
	
	###### connect to user table ########
	$mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_db_name);
	if ($mysqli->connect_error) {
		die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}
	
	//check user exist in table (using Facebook ID)
	$results = $mysqli->query("SELECT COUNT(*) FROM user WHERE fbid=".$user_id);
	$get_total_rows = $results->fetch_row();
	
	
	if(!$get_total_rows[0]){ //no user exist in table, create new user
		$insert_row = $mysqli->query("INSERT INTO user (fbid, fullname, email) VALUES(".$user_id.", '".$user_name."', '".$user_email."')");
	}
	//to be corrected
	$sql="SELECT  id FROM user where fbid=".$user_id." limit 1";
 $results_latest = $mysqli->query($sql);

 while($row = $results_latest->fetch_object())
 {
  $_SESSION["user_id"]=$row->id;
 }
	
	
	//session ver is set, redirect user 
	header("location: ". $redirect_url."vote/");
}
	
	else
	{
		//display login url 
		$login_url = $helper->getLoginUrl( array( 'email', 'public_profile' ) );
	}
if(isset($_SESSION["fb_user"]))
	{
   header("location: ". $redirect_url."vote");
    }

?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FaceMash-Welcome!</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel ="stylesheet" href="css/style.css">
    <link rel ="stylesheet"href="css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/bootstrap-social.css">
    
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>    
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    
    <div class="container">
    <div class="wrapper">
        
<p class="title">Welcome to FaceMash, Rate your friends Pictures.
        </p>
        <p class="login">
              <a class="btn  btn-social btn-facebook" href="<?php echo $login_url ?> ">
    <i class="fa fa-facebook"></i> Sign in with Facebook
  </a>
        </p>
        </div>
    
    </div>
    
    <div class="footer">
    <div id="container">
        
        <p class="text-muted credit">Facemash &copy; 2014</p>
        
        </div>
    </div>
    <?php 
    if(isset($_GET['error'])&&$_GET['error']==1){
    echo'<div class="alert >
       <a href="#" class="close" data-dismiss="alert">&times;</a>
       <strong>Warning!</strong>please login first.
   </div>';
   }
   
   ?>
   
    
    

  
</body>
</html>
