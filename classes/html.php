<?php
/**
* class html สร้าง html ต่างๆ
* create by mr.v
*/
class html {
	/**
	 *  a(input,url,name,array(name=>value,name2=>value2)) สร้าง link หรือ name
	 */
	static public function a($input, $url='', $name='', $option='') {
		$output = "<a";
		if ($url != null) {$output .= " href=\"".$url."\"";}
		if ($name != null) {$output .= " name=\"".$name."\"";}
		if ($option != null) {
			foreach ($option as $key=>$val) {
				$output .= " ".$key."=\"".$val."\"";
			}
		}
		$output .= ">".$input."</a>";
		return $output;
	}//a
	
	/**
	 *  button(type,name,value,text,option) สร้างปุ่มกด
	 */
	static public function button($type='submit',$name='',$value='',$input,$option='') {
		if (isset($type)) {
			if (strtolower($type) != "button" && strtolower($type) != "reset" && strtolower($type) != "submit") {
				$type = "submit";
			}
		}
		$output = "<button type=\"".strtolower($type)."\"";
		if (isset($name)) {$output .= " name=\"$name\"";}
		if (isset($value)) {$output .= " value=\"$value\"";}
		if ($option != null) {
			foreach ($option as $key=>$val) {
				$output .= " ".$key."=\"".$val."\"";
			}
		}
		$output .= ">$input</button>";
		return $output;
	}//button
	
	/**
	 *  div($input, array('name'=>'val')) แสดง div
	 */
	static public function div($input, $option='') {
		$output = "<div";
		if ($option != null) {
			foreach ($option as $key=>$val) {
				$output .= " ".$key."=\"".$val."\"";
			}
		}
		$output .= ">$input</div>";
		return $output;
	}//div
	
	/**
	 *  img($src, $border, $alt, $option) แสดงรูปภาพ
	 */
	static public function img($src,$border='0',$alt='',$option='') {
		$output = "<img src=\"$src\" border=\"$border\"";
		if ($alt != null) {$output .= " alt=\"$alt\"";} else {$output .= " alt=\"\"";}
		if ($option != null) {
			foreach ($option as $key=>$val) {
				$output .= " ".$key."=\"".$val."\"";
			}
		}
		$output .= " />";
		return $output;
	}//img
	
	/**
	* input(type,name,value,option) สร้างช่อง input ขึ้นมา
	* รวมถึง textarea ด้วย
	*/
	static public function input($type='text',$name='',$value='',$option='', $checkval='') {
		if (isset($type)) {
			if ($type == "textarea") {
				//สร้าง textarea//
				$output = "<textarea";
				if (isset($name)) {$output .= " name=\"$name\"";}
				if ($option != null) {
					foreach ($option as $key=>$val) {
						$output .= " ".$key."=\"".$val."\"";
					}
				}
				$output .= ">";
				if (isset($value)) {$output .= $value;}
				$output .= "</textarea>";
			} elseif ($type == "radio" || $type == "checkbox") {
				$output = "<input type=\"$type\"";
				if (isset($name)) {$output .= " name=\"$name\"";}
				if (isset($value)) {$output .= " value=\"$value\"";}
				if ($option != null) {
					foreach ($option as $key=>$val) {
						$output .= " ".$key."=\"".$val."\"";
					}
				}
				if (is_array($checkval)) {
					foreach ($checkval as $item) {
						if ($value == $item) {$output .= " checked=\"checked\"";}
					}
				} else {
					if ($checkval != null && $value != null) {
						if ($value == $checkval) {$output .= " checked=\"checked\"";}
					}
				}
				$output .= " />";
			} else {
				$output = "<input type=\"$type\"";
				if (isset($name)) {$output .= " name=\"$name\"";}
				if (isset($value)) {$output .= " value=\"$value\"";}
				if ($option != null) {
					foreach ($option as $key=>$val) {
						$output .= " ".$key."=\"".$val."\"";
					}
				}
				$output .= " />";
			}
		}
		return $output;
	}//input (include textarea)
	
	/**
	* nbs($num='1'); non breaking space (&nbsp;) สร้างพื้นที่ว่างตามจำนวน
	*/
	static public function nbs($num='1') {
		$output = "";
		for ($inbs=1;$inbs<=$num;$inbs++) {
			$output .= "&nbsp;";
		}
		return $output;
	}//nbs
	
	/**
	 *  option($display,$value,$option) ใช้คู่กับ html::select()
	 */
	static public function option($value='',$display='',$option='',$checkval='') {
		$output = "<option";
		if ($value != null) {$output .= " value=\"$value\"";} else {$output .= " value=\"\"";}
		if ($option != null) {
			foreach ($option as $key=>$val) {
				$output .= " ".$key."=\"".$val."\"";
			}
		}
		if ($checkval != null && $value != null) {
			if ($value == $checkval) {
				$output .= " selected=\"selected\"";
			}
		}
		$output .= ">";
		if ($display != null) {$output .= $display;}
		$output .= "</option>\n";
		return $output;
	}//option
	
	/**
	 *  select($name,$size,$option)
	 */
	static public function select($name='',$size='',$option='') {
		if ($name == "end") {$output = "</select>\n";} else {
			$output = "<select";
			if ($name != null) {$output .= " name=\"$name\"";}
			if ($size != null) {$output .= " size=\"$size\"";}
			if ($option != null) {
				foreach ($option as $key=>$val) {
					$output .= " ".$key."=\"".$val."\"";
				}
			}
			$output .= ">\n";
		}
		return $output;
	}//select
	
	/**
	 *  span(input,array(name=>value)) สร้างแทก <span>
	 */
	static public function span($input, $option='') {
		$output = "<span";
		if ($option != null) {
			foreach ($option as $key=>$val) {
				$output .= " ".$key."=\"".$val."\"";
			}
		}
		$output .= ">".$input."</span>";
		return $output;
	}//span
	
	/**
	* table ($option) สร้างแทก  <table> เท่านั้น ไม่เกี่ยวกับแทกอื่นๆในตาราง
	*/
	static public function table($option='') {
		if ($option == "end") {
			$output = "</table>\n";
		} else {
			$output = "<table";
			if ($option != null) {
				foreach ($option as $key=>$val) {
					$output .= " ".$key."=\"".$val."\"";
				}
			}
			$output .= ">\n";
		}
		return $output;
	}//table
	
	/**
	* table_grid($tr='',$td) สร้างตารางภายใน <table> โดยจะไล่ไปแค่ column เดียวเท่านั้น คือ <tr><td>ตามจำนวน</td></tr> จบ
	* $tr คือ option ของ <tr> ให้ใส่เป็น array ถ้ามี เช่น array("class"=>"trclass")
	* $td คือ ข้อมูลที่เป็น array หลายชั้น ตย. array("data in td"=>array("class"=>"tdclass","style"=>"width:10%;"),"data in td2"=>array("class"=>"tdclass2"))
	*/
	public function table_grid($tr='',$td) {
		$output = "<tr";
		if ($tr != null) {
			foreach ($tr as $key=>$val) {
				$output .= " ".$key."=\"".$val."\"";
			}
		}
		$output .= ">\n";//end <tr> tag
		foreach ($td as $key=>$val) {
			$output .= "<td";
			if ($val != null) {
				foreach ($val as $tdatt=>$tdval) {
					$output .= " ".$tdatt."=\"".$tdval."\"";
				}
			}
			$output .= ">".$key."</td>\n";
		}
		$output .= "</tr>\n";
		return $output;
	}//table_grid
	
	//############################################ NOT HTML tag ##########################################//
	
	/**
	 *  displayerror($intext) แสดง error
	 */
	static public function displayerror($intext) {
		return html::span(language::translate($intext, "error"), array("class"=>"txt_error"))."\n";
	}//displayerror
	
	/**
	 *  displaysyccess($intext) แสดงข้อความสำเร็จ
	 */
	static public function displaysuccess($intext, $msgtype) {
		return html::span(language::translate($intext, $msgtype), array("class"=>"txt_success"))."\n";
	}//displaysuccess
	
}
?>