<?php
/**
* class chat ทำงานเกี่ยวกับส่วนพูดคุย ไม่ว่าจะเพิ่มข้อความ หรือ แสดง
*/

class chat {
	public $msg_limit = '50';
	public $message;
	public $messages;
	public $room_id;
	public $uid;
	public $uip;
	
	public function __construct() {
		$name = new name();
		$username = (isset($_COOKIE['username']) ? $_COOKIE['username'] : "");
		$name->name = $username;
		if ($name->get_user_id() != false) {$user_id = $name->get_user_id();} else {$user_id = "0";}
		$this->uid = $user_id;
		$this->uip = _U_IP_;
	}
	
	public function add_message() {
		global $db;
		$name = new name();
		$this->write_chat_log($this->room_id,$name->get_name($this->uid),$this->uid,$this->uip,$this->message,time());
		if (substr($this->message,0,1) == "/") {// นี่คือชุดคำสั่ง
			if (method_exists($this,"command")) {
				$this->username = $name->get_name($this->uid);
				$password = (isset($_COOKIE['password']) ? $_COOKIE['password'] : "");
				$this->password = $password;
				return $this->command();
			} else {
				return false;
			}
		} else {// การสนทนาปกติ
			$rec = array();
			$rec['room_id'] = mydb::psql($this->room_id);
			$rec['msg'] = tools::safeinput($this->message,true);
			$rec['msg_add'] = time();
			$rec['name'] = $name->get_name($this->uid);// safe no need to escape anymore.
			$rec['name_id'] = mydb::psql($this->uid);
			$rec['name_ip'] = mydb::psql($this->uip);
			$db->autoexecute(_dbpre_."msg",$rec,'INSERT');
			if (!$db->errormsg()) {
				$rec = array();
				$rec['room_id'] = mydb::psql($this->room_id);
				$rec['name_id'] = mydb::psql($this->uid);
				$rec['name_ip'] = mydb::psql($this->uip);
				$rec['stat_time'] = time();
				$db->autoexecute(_dbpre_."room_stat",$rec,'INSERT');
				$this->update_room($this->room_id);
				return true;
			} else {
				return false;
			}
		}
	}//add_message
	
	/**
	* clear_inactive_user() เอาผู้ใช้ที่ออกโดยไม่ได้กด exit ออกจากระบบ
	*/
	public function clear_inactive_user() {
		global $db;
		$sql = "select * from "._dbpre_."room_stat r";
		$sql .= " inner join "._dbpre_."name n on (r.name_id = n.name_id)";
		$sql .= " where r.room_id = ".mydb::psql($this->room_id)."";
		//$sql .= " and timediff(NOW(), r.stat_time) <= 10";// timediff(NOW(), field) <= num; so num unit is second
		$sql .= " group by r.name_id";
		$sql .= " order by n.name asc";
		$rs = $db->execute($sql);
		if (!$db->errormsg()) {
			$clear_success = "yes";
			while (!$rs->EOF) {
				$timediff = (time()-strtotime($rs->fields("name_update")));
				if ($timediff >= 31) {
					$sql = "delete from "._dbpre_."name where name_id = ".$rs->fields("name_id").";";
					$db->execute($sql);
					if ($db->errormsg()) {
						$clear_success = "no";
					}
				}
				$rs->movenext();
			}
			if ($cleas_success = "yes") {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}//clear_inactive_user
	
	/**
	* clear_stat() ป้องกันไม่ให้ฐานข้อมูลล้น
	*/
	public function clear_stat() {
		global $db;
		$sql = "delete from "._dbpre_."room_stat where datediff(NOW(), stat_time) >= 1";
		$db->execute($sql);
		if (!$db->errormsg()) {
			return true;
		} else {
			return false;
		}
	}//clear_stat
	
	/**
	* get_last_update() เอาวันที่ล่าสุดในการคุยกันมาแสดง
	*/
	public function get_last_update() {
		global $db;
		$sql = "select * from "._dbpre_."msg";
		$sql .= " where room_id = ".mydb::psql($this->room_id)."";
		$sql .= " order by msg_id desc";
		$rs = $db->execute($sql);
		if (!$db->errormsg()) {
			if (!$rs->EOF) {
				return $rs->fields("msg_add");
			} else {
				return false;
			}
		} else {
			return false;
		}
	}// get_last_update
	
	/**
	* show_message ส่งข้อมูลการแชทออกไปในแบบ array ซึ่งสามารถเอาไปจัดเรียงใหม่ได้ใน theme/template
	*/
	public function show_message() {
		global $db;
		$this->update_stat();
		$sql = "select * from "._dbpre_."msg";
		$sql .= " where room_id = ".mydb::psql($this->room_id)."";
		$sql .= " order by msg_id asc";
			$rt = $db->execute($sql);
			$total = $rt->recordcount();
			$start_at = (($total-$this->msg_limit <= 0) ? 0 : $total-$this->msg_limit);
		$sql .= " limit ".$start_at.", ".$this->msg_limit."";
		$rs = $db->execute($sql);
		if (!$db->errormsg()) {
			if ($rs->EOF) {return "";}
			$addon = new addon();// เพิ่มลูกเล่นให้แชท
			while (!$rs->EOF) {
				$chatmsg = mydb::re_psql($rs->fields("msg"));
				$output[$rs->fields("msg_id")]['msg'] = $addon->plug($chatmsg);
				unset($chatmsg);
				$output[$rs->fields("msg_id")]['msg_add'] = $rs->fields("msg_add");
				$output[$rs->fields("msg_id")]['uip'] = $rs->fields("name_ip");
				$output[$rs->fields("msg_id")]['uid'] = $rs->fields("name_id");
				$name = new name();
				$output[$rs->fields("msg_id")]['name'] = $rs->fields("name");
				$rs->movenext();
			}
			$this->messages = $output;
			return $output;
		} else {
			return false;
		}
	}//show_message
	
	/**
	* show_users ส่งข้อมูลชื่อผู้แชทไปเป็นแบบ array เพื่อจัดเรียงการแสดงผลได้ใน theme/template
	* ที่ต้องทำคือ เช็คชื่อที่หมดอายุแล้วลบทิ้งด้วย!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	*/
	public function show_users() {
		global $db;
		$this->update_name();
		$this->update_stat();
		$this->clear_inactive_user();
		$sql = "select * from "._dbpre_."room_stat r";
		$sql .= " inner join "._dbpre_."name n on (r.name_id = n.name_id)";
		$sql .= " where r.room_id = ".mydb::psql($this->room_id)."";
		$sql .= " and timediff(NOW(), r.stat_time) <= 05";// timediff(NOW(), field) <= num; so num unit is second
		$sql .= " group by r.name_id";
		$sql .= " order by n.name asc";
		$rs = $db->execute($sql);
		if (!$db->errormsg()) {
			if ($rs->EOF) {return "";}
			while (!$rs->EOF) {
				$output[$rs->fields("stat_id")]['name'] = $rs->fields("name");
				$output[$rs->fields("stat_id")]['status'] = $rs->fields("name_status");
				$rs->movenext();
			}
			return $output;
		} else {
			return false;
		}
	}//show_users
	
	/**
	* update_name
	*/
	public function update_name() {
		global $db;
		$rec['name_update'] = time();
		$rec['name_ip'] = _U_IP_;
		$db->autoexecute(_dbpre_."name",$rec,'UPDATE','name_id = '.mydb::psql($this->uid).'');
		if (!$db->errormsg()) {
			//return true;
		} else {
			//return false;
		}
	}
	
	/**
	* update_room($room_id) อัปเดทการใช้ห้อง
	*/
	public function update_room($room_id) {
		global $db;
		$rec = array();
		$rec['room_last_chat'] = time();
		$db->autoexecute(_dbpre_.'room',$rec,'UPDATE','room_id = '.mydb::psql($room_id).'');
		if (!$db->errormsg()) {
			//return true;
		} else {
			//return false;
		}
	}// update_room
	
	/**
	* update_stat() อัปเดทสถานะคนดู
	*/
	public function update_stat() {
		global $db;
		$rec = array();
		$rec['room_id'] = mydb::psql($this->room_id);
		$rec['name_id'] = mydb::psql($this->uid);
		$rec['name_ip'] = mydb::psql($this->uip);
		$rec['stat_time'] = time();
		$db->autoexecute(_dbpre_."room_stat",$rec,'INSERT');
		if (!$db->errormsg()) {
			$this->clear_stat();// ป้องกันไม่ให้ฐานข้อมูลล้นเกินไป
			//return true;
		} else {
			//return false;
		}
	}//update_stat
	
	/**
	* write_chat_log($room_id,$name,$name_id,$name_ip,$time='') บันทึกการสนทนาลง .log ไฟล์
	* ล็อกนี้ บันทึกแม้กระทั่งคำสั่งจาก admin
	*/
	public function write_chat_log($room_id,$name,$name_id,$name_ip,$message,$time='') {
		global $cfg;
		if ($time == null) {$time = time();}
		$chatlog_file = dirname(dirname(__FILE__)).'/log_chat.log';
		if ($cfg['chat']['write_log'] == 'on') {
			$file = new files();
			$file->filename = $chatlog_file;
			//ยังไม่เคยบันทึก log ไฟล์มาก่อน#####
			if (!file_exists($chatlog_file)) {
				if (is_writable('./')) {
					$file->content = " ";
					if ($file->create_file($chatlog_file) == false) {
						echo language::translate("You open chat log option, but system permission did not allow to create log. Please create file log_chat.log on root of this application and set permission to 777.").'<br />\n';
					}
				} else {
					echo language::translate("You open chat log option, but system permission did not allow to create log. Please create file log_chat.log on root of this application and set permission to 777.").'<br />\n';
				}
			}
			// เริ่มบันทึก log file โดยเช็คว่าครั้งแรกหรือไม่#####
			$readlog = $file->read_file();
			if (trim($readlog) == null) {// first write log
				//write head of lof
				$log_head = "#Application: v ajax chat\r\n"
									."#Version: 1.0\r\n"
									."#Date: ".date("Y-m-d h:i:s",time())."\r\n"
									."#Fields: date time c-ip cs-username cs-name-id sc(Room) cs-message\r\n";
				$file->content = $log_head;
				$file->create_file($chatlog_file);
			}
			// start write log file#####
			$log_content = date("Y-m-d",$time)." ".date("h:i:s",$time)." ".$name_ip." ".$name." ".$name_id." ".$room_id." ".$message."\r\n";
			$file->content = $log_content;
			return $file->append_file('bottom');
		}// chat log is on
	}//write_chat_log
	
}

?>