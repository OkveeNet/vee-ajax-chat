<?php
/**
* config file จะทำหน้าที่รวมข้อมูลและเป็นจุดเดียวในการปรับแต่งข้อมูล
*/

// chat config
$cfg['chat']['msg_limit'] = "20";// จำนวนข้อความสูงสุดที่จะแสดง ค่าเดิมคือ 20
$cfg['chat']['status'] = "demo";// สถานะเว็บแชท demo คือจะซ่อนไอพีไม่ให้แม้แต่ admin ดู, off คือ ปิดการใช้งาน, on คือ เปิดการใช้งาน
$cfg['chat']['write_log'] = "on";// เปิดการเขียนบันทึกลงบนไฟล์ .log กำหนด on เพื่อเปิด off เพื่อปิด

// site config
$cfg['site']['name'] = "v ajax chat";// your site name
$cfg['site']['rootpath'] = "/ajax_chat/"; // ระบุตำแหน่งเว็บหรือสคริปตัวนี้ ต้องมี / ปิดท้ายเสมอ
$cfg['site']['ln'] = "th";// ระบุภาษา 2 ตัวอักษร ตามชื่อไฟล์ใน /languages
$cfg['site']['password'] = "password";// ระบุรหัสผ่านของผู้ดูแล

//db config
$cfg['mysql']['server'] = "localhost"; // db server
$cfg['mysql']['port'] = "3306";// db port ,default is 3306 for mysql
$cfg['mysql']['username'] = "root";// db username
$cfg['mysql']['password'] = "";// db password
$cfg['mysql']['db'] = "ajax_chat";// database name
$cfg['mysql']['dbprefix'] = "chat_";//db prefix

//theme or template config
$cfg['theme']['name'] = "default";//ระบุชื่อ theme ลงไป

require (dirname(__FILE__)."/define.inc.php");

?>