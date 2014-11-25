<?php
session_start(); //Session should always be active
include_once '../inc/imageHandler.class.php';

$saveimage=new ImageHandler('/votingsite/imgg/');






	if (isset($_SERVER["photo1"])){
	//two object of pictures uploaded and ones we are taged in
	$Tag_pics=$_SESSION["photo1"]["data"];
	
	
	
	//displaying pics got
	echo"tagged pictures  <br>------------------------------------------------------------------------------<br>";
	for($i=0;$i<sizeof($Tag_pics);$i++){
		if(!isset($Tag_pics[$i]->name)){
			$Tag_pics[$i]->name="";
				
		}
		echo $Tag_pics[$i]->name.'<img src= "'.$Tag_pics[$i]->source .'"> <hr>';
	
	}
	}
	
	if(isset($_SESSION["photo2"])){
		$Upload_pic=$_SESSION["photo2"]["data"];
	
	
	
	echo"uploaded pictures <br>------------------------------------------------------------------------------<br>";
	for($i=0;$i<sizeof($Upload_pic);$i++){
		if(!isset($Upload_pic[$i]->name)){
			$Upload_pic[$i]->name="";
		}
		
		$saveimage->processUploadedImage($Upload_pic[$i]->source, $Upload_pic[$i]->name);
		echo '<p style="display:inline; padding-left:5px;">'.$Upload_pic[$i]->name.'<img src= "'.$Upload_pic[$i]->source .'"></p>';
	
	}
	}
	
	
	