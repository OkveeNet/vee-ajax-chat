<?php
/**
* initial file ไฟล์เริ่มต้น สำหรับเรียกคำสั่ง ตอนที่คนเรียกดูเว็บเพจ เช่น คำสั่งเช็คต่างๆ เช็คล็อกอินซ้อนอะไรแบบนี้
*/

if ($cfg['chat']['status'] == 'off') {tools::redirect("off.html");}


/* start header page */
if (@$headerpage != "custom") {
		include(_THEME_PATH_."overall-header.php");
}
?>