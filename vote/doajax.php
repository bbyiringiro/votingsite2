<?php
//importing class vote to be used
require_once '../inc/error_handler.php';
require_once '../inc/vote.class.php';


//defining object of voting class
$vote=new voting();

if(isset($_POST['pic_id'] )){
	//checking if user already have voted on particular picture
	$alredyexist=$vote->exist_check($_POST['pic_id'], $_POST['user_id']);
    //if he doesn't he can vote on unvote
 if(!$alredyexist){
	if($_POST['type']=='up'){
		
		$d=$vote->up_vote($_POST['pic_id']);
		$n=$vote->__query($_POST['pic_id']);
		$num=$n['vote'];
	
	}
	elseif ($_POST['type']=='down'){
		$d=$vote->down_vote($_POST['pic_id']);
		$n=$vote->__query($_POST['pic_id']);
		$num=$n['vote'];
	}
	elseif ($_POST['type']=='undo'){	
	}
	
	//insert into voted table by saving that he or she vote!
	$vote->insvoted($_POST['pic_id'],$_POST['user_id']);
	echo $num;
	
 }
    //else if he already voted
 else{
 	echo "you already voted on this";
 }
}
?>