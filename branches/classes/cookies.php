<?php
/**
* cookies ทำงานเกี่ยวกับ cookie
*/

class cookies {
	
	/**
	* remove($name) ลบคุกกี้ออกตามชื่อคุกกี้
	*/
	static public function remove($name) {
		if (!empty($name)) {
			if (_W_ADDRESS_ == "localhost" || _W_ADDRESS_ == "localhost:81") {
				$webaddress = false;
			} else {
				$webaddress = _W_ADDRESS_;
			}
			setcookie($name, "", time()-63113851.9, _W_ROOT_, $webaddress);
			return true;
		} else {
			return false;
		}
	}//remove
	
	/**
	* write($name,$value,$timeout='0') เขียนคุกกี้
	*/
	static public function write($name, $value, $timeout='0') {
		if (!empty($name) && !empty($value)) {
			if (_W_ADDRESS_ == "localhost" || _W_ADDRESS_ == "localhost:81") {
				$webaddress = false;
			} else {
				$webaddress = _W_ADDRESS_;
			}
			setcookie($name, $value, $timeout, _W_ROOT_, $webaddress);
			return true;
		} else {
			return false;
		}
	}//write
	
}

?>