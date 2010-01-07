<?php
/**
* class files ทำงานเกี่ยวกับไฟล์ต่างๆ เปิดไฟล์เขียนไฟล์อะไรพวกนี้
*/

class files {
	public $content;
	public $filename;
	
	/**
	* append_file($position) เขียนไฟล์เพิ่มจากขของเก่า หรือเขียนต่อ
	*/
	public function append_file($position) {
		if ($position == 'top') {$mode = 'r+';}
		elseif ($position == 'bottom') {$mode = 'a';}
		else {$mode = $position;}
		$fs = fopen($this->filename, $mode);
		$result = fwrite($fs,$this->content);
		fclose($fs);
		return $result;
	}//append_file
	
	/**
	* create_file($filename) สร้างไฟล์ใหม่
	*/
	public function create_file($filename) {
		$fs = fopen($filename, 'w');
		return fwrite($fs, $this->content);
		fclose($fs);
	}//create_file
	
	/**
	* read_file() อ่านไฟล์
	*/
	public function read_file($size='') {
		$fs = fopen($this->filename, 'r');
		if ($size == null) {
			$content = fread($fs, filesize($this->filename));
		} else {
			$content = fread($fs, $size);
		}
		fclose($fs);
		return $content;
	}//read_file
	
}
?>