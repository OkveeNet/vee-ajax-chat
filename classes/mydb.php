<?php
/**
* class mydb ทำงานเกี่ยวกับฐานข้อมูล
*/

class mydb {
	
	/**
	* psql($txt,$htmlok) ป้องกันการโจมตีฐานข้อมูล
	*/
	static public function psql($string, $htmlok = 'no') {
		if (_W_MAGIC_QUOTES_GPC_)
			$string = stripslashes($string);
		if (!is_numeric($string)) {
			$string = _W_MYSQL_REAL_ESCAPE_STRING_ ? mysql_real_escape_string($string) : addslashes($string);
			if ($htmlok != "yes")
				$string = strip_tags(nl2br2($string));
		}
		return $string;
	}//psql
	
	/**
	*re_psql($string) แปลงค่าต่างๆกลับมาเป็นปกติ
	*/
	static public function re_psql($string) {
		$string = str_replace("\\r\\n","\r\n",$string);
		$string = str_replace("\\r","\r",$string);
		$string = str_replace("\\n","\n",$string);
		$string = str_replace("\\\"","\"",$string);// \\" to \"
		$string = str_replace("\'","'",$string);// \' to '
		$string = str_replace("\\'","\'",$string);// \\' to \'
		$string = str_replace("\&#039;","&#039;",$string);// \' to '
		$string = str_replace("\&quot;","&quot;",$string);
		return $string;
	}//re_psql
	
}

?>