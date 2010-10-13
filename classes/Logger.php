<?php
// Use Singleton pattern to create single central logging object
class Logger 
{
	static private $instance = NULL;
	
	private function __construct() { 		
	}
	
	private function __clone() { 
    }	

	static function getInstance() {
    	if (self::$instance == NULL) {
            self::$instance = new Logger();
    	}
    	return self::$instance;
	}
	
	function Log($str) {
	    try {
        	$file_ptr = fopen('../logs/fhslog.txt','a');
			fwrite($file_ptr, $str);
			fclose($file_ptr);
		}
		catch(Exception $e) {
   			echo "WARNING: " . $e->getMessage();
   			exit();
		} 
    }
}
?>