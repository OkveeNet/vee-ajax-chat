การติดตั้ง
แตกไฟล์ออกมาแล้วไว้ใน folder เช่น /ajax-chat
เปิดไฟล์ /includes/config.inc.php
แก้ไขสิ่งต่างๆที่จำเป็นดังนี้
$cfg['chat']['status'] เป็น on เพื่อใช้งานจริง
$cfg['site']['name'] กำหนดชื่อเว็บของคุณ
$cfg['site']['password'] กำหนด password สำหรับการเข้าเป็น admin ในห้องแชท
$cfg['mysql']['server'] กำหนด server ของ mysql เช่น 192.168.0.1 หรือปกติจะเป็น localhost
$cfg['mysql']['username'] กำหนด username ของฐานข้อมูล
$cfg['mysql']['password'] รหัสผ่านของฐานข้อมูล
$cfg['mysql']['db'] ชื่อฐานข้อมูล
จากนั้น ติดตั้งฐานข้อมูล โดยสร้างฐานข้อมูลเป็นตามชื่อที่คุณกำหนดไว้
import ไฟล์ ajax_chat_structure.sql ผ่านทาง phpmyadmin
เสร็จสิ้นขั้นตอนการติดตั้ง

คำสั่งแชทต่างๆสำหรับ admin หรือผู้ใช้โปรดดูใน help.txt