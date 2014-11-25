<?php
class ImageHandler
{
	// stored database connection
	public $db;
	private $db_host='mysql:host=localhost;dbname=votingsite';
	private $db_user='root';
	private $db_pass='';
	 
	public $save_dir;
	public function __construct($save_dir)
	{
		$this->db = new PDO($this->db_host,$this->db_user,$this->db_pass);
		$this->save_dir=$save_dir;
	}
	/**
	 * @param image $link select to be stored on owr server
	 * @return void nothing
	 */
	public function processUploadedImage($link,$fb_name)
	{
		//checking if a photos is already exist
		$sql='select * from photos where fb_name=? ';
        	$res=$this->db->prepare($sql);
        	$res->execute(array($fb_name));
        	$row=$res->rowCount();
        	if($row>0)
        		return false;
	
		
		
		
		// providing unique name to image
			$name = $this->renameFile();

		//check directory if not create
		    $this->checkSaveDir();
		// Create the full path to the image for saving
		$filepath = $this->save_dir . $name;
		// Store the absolute path to move the image
		$fileName = $_SERVER['DOCUMENT_ROOT'] . $filepath;
		// Save the image
		$data = file_get_contents($link);
		$file = fopen($fileName, 'w+');
		fputs($file, $data);
		fclose($file);
		$sql='INSERT INTO photos (fb_name,name,vote)values(?,?,?) ';
		$this->db->prepare($sql)->execute(array($fb_name,$name,0));
	
		
		
	}
	/**
	 * Ensures that the save directory exists
	 *
	 * Checks for the existence of the supplied save directory,
	 * and creates the directory if it doesn't exist. Creation is
	 * recursive.
	 *
	 * @param void
	 * @return void
	 */

	private function checkSaveDir()
	{
		// Check for the dir
		// Determines the path to check
		$path = $_SERVER['DOCUMENT_ROOT'] . $this->save_dir;
		// Checks if the directory exists
		if(!is_dir($path))
		{
			// Creates the directory
			if(!mkdir($path, 0777, TRUE))
			{
				// On failure, throws an error
				throw new Exception("Can't create the directory!");
			}
		}
	}
	/**
	 * Generates a unique name for a file
	 *
	 * Uses the current timestamp and a randomly generated number
	 * to create a unique name to be used for an uploaded file.
	 * This helps prevent a new file upload from overwriting an
	 * existing file with the same name.
	 *
	 * @param void
	 * @return string the new filename
	 */
	private function renameFile()
	{
		/*
		 * Returns the current timestamp and a random number
		* to avoid duplicate filenames
		*/
		return time() . '_' . mt_rand(1000,9999) . '.jpg';
	}
}

?>