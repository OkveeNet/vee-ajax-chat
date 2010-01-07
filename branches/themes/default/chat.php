<?php
// theme ของห้องแชท
?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	
	//focus on input msg
	$("#inputmsg").focus();
	
	//load message page
	setInterval(function(){
		$.get("<?php echo _W_ROOT_;?>chat-msg.php",{room_id:<?php echo $room_id; ?>},function(msgs){
			lastupdate = $(msgs).find("span.last-update");
			if ($(lastupdate).html() != $(".last-update").html()) {
				$("#messages").html(msgs);
				$(".chat-msg").scrollTo("#bottom");
			}
		});
	} ,3000);//end load message page (2000 = 2second)
	
	//load chat name page
	setInterval(function(){
		$.get("<?php echo _W_ROOT_;?>chat-name.php",{room_id:<?php echo $room_id; ?>},function(msgs){
			$("#users").html(msgs);
		});
	} ,2000);//end load chat name page (2000 = 2second)
	
	$("#inputform").submit(function() {
		inputmsg = $("#inputmsg").val();
		room_id = $("#room_id").val();
		userip = $("#userip").val();
		userid = $("#userid").val();
		$.post("<?php echo _W_ROOT_;?>chat-input.php",{room_id: room_id, uip: userip, uid: userid, message: inputmsg},function(data){
			$("#result_txt").html(data);
		});
		$("#inputmsg").val('');
		return false;
	});
});// jquery ready
</script>
<div class="page-chat">
	<div class="txt_logout"><a href="quit-chat.php">Exit chat room</a></div>
    <div class="chat-msg"><span id="messages"></span></div>
    <div class="chat-name"><span id="users"></span></div>
    <div class="clear"></div>
    <div class="chat-input">
		<form method="post" action="<?php echo _W_THIS_PAGE_; ?>" id="inputform">
		<input type="hidden" name="room_id" value="<?php echo $room_id; ?>" id="room_id" />
		<input type="hidden" name="uip" value="<?php echo _U_IP_; ?>" id="userip" />
		<input type="hidden" name="uid" value="<?php echo $user_id; ?>" id="userid" />
		<input type="text" name="message" id="inputmsg" />
		<button type="submit" name="btnact" value="addmsg">Send</button>
		<span id="result_txt"></span>
		</form>
	</div>
</div>