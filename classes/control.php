<?php
/**
* control ควบคุมส่วนเสริมของ chat
* เช่น คำสัี่งต่างๆ
*/
class control extends chat {
	public $username;// entities มาแล้วไม่ต้องทำอีก
	public $password;// มาจาก cookie md5 แล้ว
	
	public function __construct() {
		
	}//__contruct
	
	/**
	* command() ตัวรับคำสั่งใน chat
	*/
	public function command() {
		if (strpos($this->message, " ") == false) {
			$cmdopen = $this->message;
			$cmdfollow = "";
		} else {
			$pattern = "/(?<cmd>^\/[A-Za-z0-9]+\s)(?<val>.*|\Q[]<>\^$.|?*+(){}\E)/";// /(?<name>.*) (?<last>\w+.*)/
			preg_match($pattern, $this->message, $match);
			$cmdopen = trim($match['cmd']);
			$cmdfollow = (isset($match['val']) ? trim($match['val']) : "");
		}
		switch ($cmdopen) {
			case "/clear":
				return $this->clear_chat();
				break;
			case "/info":
				return $this->info_user($cmdfollow);
				break;
			case "/kick":
				return $this->kick_user($cmdfollow);
				break;
			case "/logout":
				return $this->logout();
				break;
			case "/nick":
				return $this->change_name($cmdfollow);
				break;
			case "/password":
				return $this->login($cmdfollow);
				break;
			default :
				return true;
				break;
		}
	}// command
	
	/*############################### คำสั่งย่อยๆจาก switch case อยู่ล่างจากนี้ ###############################*/
	
	/**
	* change_name($newname = '') เปลี่ยนชื่อผู้ใช้
	*/
	public function change_name($newname = '') {
		global $db;
		if ($newname == null) {return false;}
		$this->logout();// ถ้า admin จะได้ไม่มี cookie password ที่ไม่ตรงกัน เนื่องจากใน cookie password มีการ md5 ชื่อเก่าอยู่
		$name = new name();
		$name->name = $newname;
		if ($name->name_exist() == true) {
			return false;
		} else {
			$rec = array();
			$rec['name'] = tools::safeinput($newname);
			$rec['name_update'] = time();
			$db->autoexecute(_dbpre_.'name',$rec,'UPDATE',"name = '".$this->username."'");
			if (!$db->errormsg()) {
				if (cookies::write('username',$newname,time() + (7 * 24 * 60 * 60)) != false) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}//change_name
	
	/**
	* check_login() เช็ครหัสผ่านว่าได้ล็อกอินแล้วรึยัง
	*/
	public function check_login() {
		global $cfg;
		$name = new name();
		$name->name = $this->username;// htmlentities แล้วตามข้างบนสุด
		if ($name->encode_password($cfg['site']['password']) == $this->password) {
			return true;
		} else {
			return false;
		}
	}//check_login
	
	/**
	* clear_chat() เคลียร์หน้าจอแชท
	*/
	public function clear_chat() {
		global $db;
		if ($this->check_login() == true) {
			$sql = "truncate `"._dbpre_."msg`";
			$db->execute($sql);
			if (!$db->errormsg()) {
				return true;
			} else {
				$sql = "delete from "._dbpre_."msg";
				$db->execute($sql);
				if (!$db->errormsg()) {
					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}// clear_chat
	
	/**
	* info_user($username) เรียกดูข้อมูลผู้ใช้
	*/
	public function info_user($targetname) {
		global $cfg;
		if ($this->check_login() == true) {
			$name = new name();
			$name->name = $targetname;
			$user_id = $name->get_user_id();
			if ($user_id != false) {
				$output = "Name: ".tools::safeinput($targetname).",";
				$output .= " IP: ".($cfg['chat']['status'] == 'demo' ? "xxx.xxx.xxx.xxx" : $name->get_info($user_id,'name_ip')).",";
				$output .= " Status: ".(($name->get_info($user_id,'name_status') == '1') ? "Admin" : "User").",";
				$output .= " Join since: ".$name->get_info($user_id,'name_add').",";
				$output .= " Last active: ".$name->get_info($user_id,'name_update');
				return $output;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}// info_user
	
	/**
	* kick_user($username) เตะออกจากห้อง
	*/
	public function kick_user($username) {
		global $db;
		if ($this->check_login() == true) {
			$sql = "delete from "._dbpre_."name where name = '".tools::safeinput($username)."'";
			$db->execute($sql);
			if (!$db->errormsg()) {
				cookies::write("kick","yes",time()+(60));
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}// kick_user
	
	/**
	* login()
	*/
	public function login($passinput = '') {
		global $cfg, $db;
		if ($passinput == null) {return false;}
		if ($cfg['site']['password'] == trim($passinput)) {
			$name = new name();
			$name->name = $this->username;// htmlentities แล้ว
			$hashpassword = $name->encode_password($passinput);
			if ($hashpassword != false) {
				$rec = array();
				$rec['name_status'] = '1';
				$rec['name_update'] = time();
				$db->autoexecute(_dbpre_.'name',$rec,'UPDATE',"name = '".$this->username."'");
				if (!$db->errormsg()) {
					cookies::write("password", $hashpassword);
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}// login
	
	/**
	* logout()
	*/
	public function logout() {
		global $db;
		$rec = array();
		$rec['name_status'] = '0';
		$rec['name_update'] = time();
		$db->autoexecute(_dbpre_.'name',$rec,'UPDATE',"name = '".mydb::psql($this->username)."'");
		if (!$db->errormsg()) {
			cookies::remove("password");
			return true;
		} else {
			return false;
		}
	}// logout
	
}
?>