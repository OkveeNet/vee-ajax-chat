<?php
/**
* class tools เครื่องมือทั้งหลายแหล่
*/

class tools {
	
	/**
	* redirect($page); ส่งไปหน้าอื่นที่ระบุไว้
	*/
	static public function redirect($page) {
		header("Location:".$page);
		exit();
	}//redirect
	
	/**
	safeinput($string)
	*/
	static public function safeinput($string) {
		$string = htmlentities($string, ENT_QUOTES, "utf-8");
		return $string;
	}//safeinput
	
	/**
	safeoutput()
	*/
	static public function safeoutput($string, $html = false)
	{
	 	if (!$html)
			$string = @htmlentities(strip_tags($string), ENT_QUOTES, 'utf-8');
		return $string;
	}//safeoutput
	
}
?>