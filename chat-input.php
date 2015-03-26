<?php
/**
* chat-input
* กรอกข้อมูลการคุยเข้ามา บันทึกลงฐานข้อมูล
*
* ในส่วนหัว ถ้าต้องการกำหนดส่วนหัวพิเศษเฉพาะบางหน้า ให้กำหนด $headerpage = "custom"; แล้ว include header เอาเอง
* ในส่วนท้ายก็ทำแบบเดียวกัน กำหนด $footerpage = "custom"; แล้ว include footer เอาเอง
* ทั้งสองส่วน หากไม่กำหนด จะใช้ header & footer ตาม template หลัก
*/
$headerpage = 'custom';
require (dirname(__FILE__)."/includes/config.inc.php");
/* content start */##########
$message = (isset($_POST['message']) ? trim($_POST['message']) : "");
$room_id = (isset($_POST['room_id']) ? trim($_POST['room_id']) : "");
$uid = (isset($_POST['uid']) ? trim($_POST['uid']) : "");
$uip = (isset($_POST['uip']) ? trim($_POST['uip']) : "");
$username = (isset($_COOKIE['username']) ? $_COOKIE['username'] : "");

$name = new name();
$name->name = $username;
if ($name->get_user_id() != false) {$user_id = $name->get_user_id();} else {$user_id = "0";}

if ($message != null && $uid != null && $uip != null && $name->name_exist() == true) {
	if ($uid != $user_id) {$uid = $user_id;}
	if ($uip != _U_IP_) {$uip = _U_IP_;}
	$chat = new control();// แต่เดิมนั้นใช้  new chat(); แต่เนื่องจากเพิ่มการควบคุมคำสั่งต่างๆ จึงใช้คลาส control มาเสริม จึงต้องเปลี่ยนเป็น control() แทน ในขณะที่คำสั่งแกนหลักใน chat() ยังใช้งานได้ปกติเหมือนเดิม
	$chat->message = $message;
	$chat->room_id = $room_id;
	$chat->uid = $uid;
	$chat->uip = $uip;
	$add_result = $chat->add_message();
	if ($add_result == true) {
		// success
		if ($add_result != null && is_string($add_result)) {
			echo $add_result;
		} else {
			// echo "true";
		}
	} elseif ($add_result == false) {
		// error add message
		echo language::translate("Error, please try gain.", "error");
	} else {
		echo $add_result;
	}
}
/* content end */##########
$footerpage = 'custom';
require (dirname(__FILE__)."/includes/endpage.php");
?>