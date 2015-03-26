<?php
/**
* ajax chat by วี automatic
* application นี้ สามารถนำไปดัดแปลง ต่อเติม แก้ไขได้ทุกส่วน
* เมื่อมีการเปลี่ยนโค้ดภายในใดๆก็ตามและเอาไปเผยแพร่ใหม่ โปรดระบุชื่อผู้จัดทำเป็นคนแรกในไฟล์ด้วย (ตามที่เขียนไว้ด้านบน) อย่าลบออกไป
* หรือหากระบุชื่อต่อสาธารณะได้จะเป็นการดี
* ไม่อนุญาตให้นำ application นี้ไปจำหน่าย
* นำไปใช้งานได้ทั้งเชิงพาณิชย์, ส่วนบุคคล และทุกปรเภท
*
* ในส่วนหัว ถ้าต้องการกำหนดส่วนหัวพิเศษเฉพาะบางหน้า ให้กำหนด $headerpage = "custom"; แล้ว include header เอาเอง
* ในส่วนท้ายก็ทำแบบเดียวกัน กำหนด $footerpage = "custom"; แล้ว include footer เอาเอง
* ทั้งสองส่วน หากไม่กำหนด จะใช้ header & footer ตาม template หลัก
*/
require (dirname(__FILE__)."/includes/config.inc.php");
/* content start */##########
$act = (isset($_GET['act']) ? trim($_GET['act']) : "");
$chatroomfile = "chatroom.php";
$name = (isset($_POST['name']) ? trim($_POST['name']) : "");
$username = (isset($_COOKIE['username']) ? $_COOKIE['username'] : "");
cookies::remove("kick");
if ($username != null) {
	$cname = new name();
	$cname->name = $username;
	if ($cname->name_exist() == true) {
		tools::redirect($chatroomfile);
	} else {
		cookies::remove("username");
		tools::redirect(_W_THIS_PAGE_);
	}
} else {
	if ($act == "submit" && $name != null) {
		$sql = "select * from "._dbpre_."name where name = '".tools::safeinput($name)."';";
		$rs = $db->execute($sql);
		if ($rs->EOF) {
			$cname = new name();
			$cname->name = $name;// กำหนดชื่อให้ class name
			$cname->uip = _U_IP_;
			if ($cname->add_user() == null) {
				tools::redirect($chatroomfile);
			} else {
				$statusmsg = $cname->add_user();
			}
		} else {
			$statusmsg = html::displayerror("This name is already exists! Please use other name.");
		}
	} elseif ($act == "submit" && $name == null) {
		$statusmsg = html::displayerror("Please enter your desire name.");
	}
	include(_THEME_PATH_."index.php");
}
// ทดลองวันที่เพิ่มกับ time()
//$time = time();
//$time_add = time()+60;// add 1 minute
//$time_add = time()+(60*60);// add 1 hour
//$time_add = time()+(24*60*60);// add 1 day
//$time_add = time()+(7*24*60*60);// add 7 days
//echo date("Y-m-d h:i:s A",$time)."<br />add: ".date("Y-m-d h:i:s A",$time_add);
/* content end */##########
require (dirname(__FILE__)."/includes/endpage.php");
?>