<?php
require_once '../inc/error_handler.php';
require_once '../inc/photo.class.php';
$_GET['user_id']=1;

if(isset($_GET['user_id'])){
$user_id=$_GET['user_id'];

$photo=new photo();
$result=$photo->selectone($user_id);
echo json_encode($result);



}

