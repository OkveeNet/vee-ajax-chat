<?php
/**
* chat name ชื่อผู้แชท
*
* ในส่วนหัว ถ้าต้องการกำหนดส่วนหัวพิเศษเฉพาะบางหน้า ให้กำหนด $headerpage = "custom"; แล้ว include header เอาเอง
* ในส่วนท้ายก็ทำแบบเดียวกัน กำหนด $footerpage = "custom"; แล้ว include footer เอาเอง
* ทั้งสองส่วน หากไม่กำหนด จะใช้ header & footer ตาม template หลัก
*/

$headerpage = 'custom';
require (dirname(__FILE__)."/includes/config.inc.php");
/* content start */##########

$room_id = (isset($_GET['room_id']) ? $_GET['room_id'] : "");
$chat = new chat();
$chat->room_id = $room_id;
$names = $chat->show_users();

/* เป็น template ในตัว */
if ($names != false) {
	foreach ($names as $key=>$val) {
		?>
        <span class="<?php if ($val['status'] == '1') {?>name-list-admin<?php } else {?>name-list<?php }?>"><?php echo $val['name']; ?></span><br />
        <?php
	}
} elseif ($names == null) {
	echo " ";
} else {
	echo language::translate("Error while connect to db.","error");
}
/* content end */##########
$footerpage = 'custom';
require (dirname(__FILE__)."/includes/endpage.php");

?>