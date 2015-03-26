<?php
/**
* chat addon เพิ่มลูกเล่นให้แชทตรงนี้
*/
class addon {
	
	public function plug($message) {
		$output = $message;
		$output = $this->emoticon($output);
		$output = $this->filterword($output);
		return $output;
	}//addon
	
	/*############################ method/function ย่อยจะอยู่บรรทัดล่างจากนี้ ############################*/
	
	/**
	* emoticon($message) แปลงอักษรเป็นภาพอารมณ์
	*/
	public function emoticon($message) {
		$output = str_replace(":)",html::img(_W_ROOT_.'images/emo/smile.gif','0',':)',array('title'=>'smile')),$message);
		return $output;
	}// emoticon
	
	/**
	* filterword($message) กรองคำหยาบ
	*/
	public function filterword($message) {
		$output = str_replace("fuck","f***",$message);
		return $output;
	}// filterword
	
}

?>