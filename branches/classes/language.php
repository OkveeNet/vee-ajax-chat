<?php
/**
*แปลภาษาโดยแยกเป็นส่วนต่างๆใน 1 เว็บ
*by vee
*www.buytoon.com
*language class version 1
*/
class language {
	
	/**
	*translate language use word,_site_ln_,section,table
	*/
	static public function translate($textin, $section="general") {
		$section = strtolower($section);
		if (file_exists(_W_ROOT_PATH_."/languages/"._W_LN_."/".strtolower($section).".php")) {
			include(dirname(dirname(__FILE__))."/languages/"._W_LN_."/".strtolower($section).".php");
		}
		$transtext = "";
		if ($section == "error") {
			if (isset($_error[$textin])) {$transtext = $_error[$textin];}
		}elseif ($section == "general") {
			if (isset($_general[$textin])) {$transtext = $_general[$textin];}
		}
		//-----//
		if ($transtext == null) {
			$transtext = $textin;
		}
		return $transtext;
	}//translate
}
?>