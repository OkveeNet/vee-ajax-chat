<?php
/**
* ส่วนของห้องแชท
*
* ในส่วนหัว ถ้าต้องการกำหนดส่วนหัวพิเศษเฉพาะบางหน้า ให้กำหนด $headerpage = "custom"; แล้ว include header เอาเอง
* ในส่วนท้ายก็ทำแบบเดียวกัน กำหนด $footerpage = "custom"; แล้ว include footer เอาเอง
* ทั้งสองส่วน หากไม่กำหนด จะใช้ header & footer ตาม template หลัก
*/
require (dirname(__FILE__)."/includes/config.inc.php");
/* content start */##########
$room_id = (isset($_GET['room_id']) ? $_GET['room_id'] : "1");// default is 1 or look at chat_room in db.
$username = (isset($_COOKIE['username']) ? $_COOKIE['username'] : "");
if ($username == null) {tools::redirect("./");}
$name = new name();
$name->name = $username;
if ($name->name_exist() == false) {tools::redirect("quit-chat.php");}
if ($name->get_user_id() != false) {$user_id = $name->get_user_id();} else {$user_id = "0";}

// include file from theme
include(_THEME_PATH_."chat.php");
/* content end */##########
require (dirname(__FILE__)."/includes/endpage.php");
?>