<?php
require_once '../inc/vote.class.php';
session_start();
//session var is still there
if(!isset($_SESSION["fb_user"]))
	header("location: ../?error=1");
else{


//
$pic_id=4;
$vote=new voting();
$data=$vote->__query($pic_id);

?>




<!DOCTYPE html>
<html>
<head>
    <title>Welcome | Facemash</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
   
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    
    
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,400italic' rel='stylesheet' type='text/css'>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    
<body>
    <div class="logo"> FaceMash </div>
    <div class="sub-logo">Rate your friends pictures</div>
    
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>
                <a class="navbar-brand"  href="index.html">facemash</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="profile-image user" data-user="<?php echo $_SESSION["user_id"];?>">
                    
                    <img src="https://graph.facebook.com/<?php echo $_SESSION["fb_user"]["id"]; ?>/picture/" class="img-circle">
                       
                    </li>
                    <li>
                        <a href="/votingsite/?log-out=1">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="box">
                <div class="col-lg-12  ">
                  <div class="img" data-id="">
                    <img class="img-responsive  img-border img-full" src="" alt="" id="image">
                  </div>
                    <p class="caption">#caption goes here........   <a class="pull-right dope" href="#"><img src="https://graph.facebook.com/<?php echo $_SESSION["fb_user"]["id"]; ?>/picture/" class="img-circle"><?php echo $_SESSION["fb_user"]["name"];?></a>    </p>
                    <div class="vote">
                        <p>  <a  class="up"><i class="fa fa-chevron-up"></i></a><small>vote up</small></p>
                        <p class="votes"></p>
                        <p><a  class="down"><i class="fa fa-chevron-down"></i></a><small>vote down</small></p>
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    <footer>
    <div class="container">
        <div class="row">
                 <div class="col-lg-12 text-center">
                     <p> Facemash &copy; 2014</p>
            </div>
        
        
        </div>
        
        </div>
    </footer>
    


    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/vote.js" ></script>
    </body>
</html>
<?php }?>

