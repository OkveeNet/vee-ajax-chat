<?php
/**
*chat-msg แสดงข้อความ
*
* ในส่วนหัว ถ้าต้องการกำหนดส่วนหัวพิเศษเฉพาะบางหน้า ให้กำหนด $headerpage = "custom"; แล้ว include header เอาเอง
* ในส่วนท้ายก็ทำแบบเดียวกัน กำหนด $footerpage = "custom"; แล้ว include footer เอาเอง
* ทั้งสองส่วน หากไม่กำหนด จะใช้ header & footer ตาม template หลัก
*/
$headerpage = 'custom';
require (dirname(__FILE__)."/includes/config.inc.php");
/* content start */##########
$room_id = (isset($_GET['room_id']) ? $_GET['room_id'] : "");
$username = (isset($_COOKIE['username']) ? $_COOKIE['username'] : "");
$kick = (isset($_COOKIE['kick']) ? $_COOKIE['kick'] : "");
// something about name
$name = new name();
$name->name = $username;
// start chat show message
if ($name->name_exist() == true) {
	$chat = new chat();
	$chat->room_id = $room_id;
	$chat->msg_limit = $cfg['chat']['msg_limit'];
	$message = $chat->show_message();


	/* ส่วนนี้เป็น template ในตัว */
	if ($message != false) {
		?>
		<script language="javascript" type="text/javascript">
		$(document).ready(function(){
			$(".chat-msg").scrollTo("#bottom");
		});// jquery ready
		</script>
        <?php
		echo "<div class=\"message\"><span class=\"last-update\" id=\"lastupdate\">".$chat->get_last_update()."</span></div>\r\n";
		//echo html::span($chat->get_last_update(),array("class"=>"last-update","id"=>"lastupdate"));;
		foreach ($message as $key=>$val) {
			?>
			<div class="message"><span class="chat-name"><?php echo $val['name']; ?><span class="chat-time">(<?php echo $val['msg_add']; ?>)</span>:</span> <?php echo $val['msg']; ?></div>
			<?php
		}
		?>
        <a name="bottom" id="bottom"></a>
        <?php
	} elseif ($message == null) {
		echo "";
	} else {
		echo language::translate("Error while connect to db.","error");
	}
} elseif ($kick == 'yes') {
	//cookies::remove("kick");
	echo language::translate("You have been kick out of room.");
} else {
	echo language::translate("Connection time out, please re-enter the room.");
}
/* content end */##########
$footerpage = 'custom';
require (dirname(__FILE__)."/includes/endpage.php");
?>