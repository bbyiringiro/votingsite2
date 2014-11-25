<?php
require_once 'error_handler.php';


class voting
{
           // stored database connection
           private  $db;
           private $db_host='mysql:host=localhost;dbname=votingsite';
           private $db_user='root';
           private $db_pass='';
           
// constructor opens database connection
        function __construct(){

                  $this->db = new PDO($this->db_host,$this->db_user,$this->db_pass);
        }
// destructor closes database connection
       
        public function  up_vote($a){
        	$sql='update photos set vote=vote+1 where id=? LIMIT 1';
        	$res=$this->db->prepare($sql);
        	$res->execute(array($a));
        }
        public function  down_vote($a){
        	$sql='update photos set vote=vote-1 where id=? LIMIT 1';
        	$res=$this->db->prepare($sql);
        	$res->execute(array($a));
        }
        public function exist_check($a,$b){
        	$sql='SELECT id from  voted where pic_id=? && user_id=?';
        	$res=$this->db->prepare($sql);
        	$res->execute(array($a,$b));
        	$row=$res->rowCount();
        	if ($row>0)
        		return true;
        	else 
        		return false;
        }
        public function insvoted($y,$z){
        	$sql='INSERT into voted(pic_id,user_id)values(?,?)';
        	$ins=$this->db->prepare($sql);
        	$ins->execute(array((int)$y,(int)$z));
        }
        public function __query($id){
        	$sql='select * from photos where id=?';
        	$dat=$this->db->prepare($sql);
        	$dat->execute(array($id));
        	return $dat->fetch();
        	
        
        	     
        }
}


?>