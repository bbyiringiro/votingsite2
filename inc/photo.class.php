<?php
class photo
{
	// stored database connection
   // stored database connection
           private  $db;
           private $db_host='mysql:host=localhost;dbname=votingsite';
           private $db_user='root';
           private $db_pass='';
           
// constructor opens database connection
        function __construct(){

                  $this->db = new PDO($this->db_host,$this->db_user,$this->db_pass);
        }
        
	public function getPhotos(){
		$sql='SELECT * from photos ORDEY by up desc';
		$result=$this->db->prepare($sql);
		$result->execute();
		$res=array();
		while($row=$result->fetch()){
			$res[]=$row;
		}
	    return $res;
	}
	public function selectone($user_id){
		$skip=true;
		
		$picnum=$this->countpic();
		$i=0;
	
		while ($skip){
			 if($picnum<=$i)
			 	
			 	return json_encode(false);
			 	
			 	
			 	
			$res=null;
			$skip=false;
		$sql='SELECT * FROM photos ORDER BY RAND() limit 1';
		$dat=$this->db->prepare($sql);
		$dat->execute();
		$res=$dat->fetch();
		
	
		//check whether user all ready have voted photo
		$skip=$this->photovotedbyuserskipped($res['id'],$user_id);
		//if so photo are skipped and select randomly
		$i++;
		}
		return $res;
		}
	//this function is for checking if a user already have voted a particular pic
	private  function photovotedbyuserskipped($pic_id,$user_id){
		$sql='SELECT id from  voted where pic_id=? && user_id=?';
        	$res=$this->db->prepare($sql);
        	$res->execute(array($pic_id,$user_id));
        	$row=$res->rowCount();
        	
        	if ($row>0)
        		return true;
        	else 
        		return false;
		
	}
	function countpic(){
		$sql='SELECT * from photos ';
		$res=$this->db->prepare($sql);
		$res->execute();
		$row=$res->rowCount();
		return $row;
		
	}
	
}






