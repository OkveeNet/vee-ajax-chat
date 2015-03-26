<?php
/**
* class name ทำงานเกี่ยวกับชื่อผู้ใช้
*/

class name {
	public $name;
	public $uip;
	
	/**
	*add_user() เพิ่มผู้แชท
	*/
	public function add_user() {
		global $db;
		$rec = array();
		$rec['name'] = tools::safeinput($this->name);
		$rec['name_ip'] = mydb::psql($this->uip);
		$rec['name_add'] = time();
		$db->autoexecute(_dbpre_."name",$rec,'INSERT');
		if (!$db->errormsg()) {
			if (cookies::write('username',$this->name,time() + (7 * 24 * 60 * 60)) != false) {
				$statusmsg = "";
			} else {
				$statusmsg = html::displayerror("Sorry, please try again.");
			}
		} else {
			$statusmsg = html::displayerror("Database error.");
		}
		return $statusmsg;
	}// add_user
	
	/**
	* encode_password($password) เข้ารหัสผ่าน
	*/
	public function encode_password($password) {
		global $db;
		if ($password == null) {
			return false;
		} else {
			$newencode = md5($this->name.":".$password.":");
			return $newencode;
		}
	}//encode_password
	
	/**
	* get_info($user_id,$field) เอาข้อมูลจากตาราง
	*/
	public function get_info($user_id,$field) {
		global $db;
		$sql = "select * from "._dbpre_."name where name_id = '".mydb::psql($user_id)."';";
		$rs = $db->execute($sql);
		if (!$db->errormsg()) {
			if (!$rs->EOF) {
				return $rs->fields($field);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}//get_info
	
	/**
	* get_name($user_id) เอาชื่อจาก user_id
	* มันเข้ารหัสไว้ ดังนั้นจะออกมาเป็น < -> &lt; แบบนี้
	*/
	public function get_name($user_id) {
		if ($this->get_info($user_id,'name') != false) {
			return $this->get_info($user_id,'name');
		} else {
			return language::translate("Error loading name.","error");
		}
	}//get_name
	
	/*
	* get_user_id() เอา id จากชื่อ
	*/
	public function get_user_id() {
		global $db;
		$sql = "select * from "._dbpre_."name where name = '".tools::safeinput($this->name)."';";
		$rs = $db->execute($sql);
		if (!$db->errormsg()) {
			if (!$rs->EOF) {
				return $rs->fields("name_id");
			} else {
				return false;
			}
		} else {
			return false;
		}
	}// get_user_id
	
	/**
	* name_exist() เช็คว่ามีชื่อผู้แชทใน db?
	*/
	public function name_exist() {
		global $db;
		$sql = "select * from "._dbpre_."name where name = '".tools::safeinput($this->name)."';";
		$rs = $db->execute($sql);
		if (!$db->errormsg()) {
			if (!$rs->EOF) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}// name_exist
	
}

?>