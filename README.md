**โปรดทราบ** chat ตัวนี้ออกมานานมากแล้ว ตั้งแต่ปี 2010 ดังนั้นงดคำถามคำตอบครับ !!

# Vee ajax chat

## การติดตั้ง
แตกไฟล์ออกมาแล้วไว้ใน folder เช่น /ajax-chat
เปิดไฟล์ /includes/config.inc.php
แก้ไขสิ่งต่างๆที่จำเป็นดังนี้
`$cfg['chat']['status']` เป็น on เพื่อใช้งานจริง
`$cfg['site']['name']` กำหนดชื่อเว็บของคุณ
`$cfg['site']['password']` กำหนด password สำหรับการเข้าเป็น admin ในห้องแชท
`$cfg['mysql']['server']` กำหนด server ของ mysql เช่น 192.168.0.1 หรือปกติจะเป็น localhost
`$cfg['mysql']['username']` กำหนด username ของฐานข้อมูล
`$cfg['mysql']['password']` รหัสผ่านของฐานข้อมูล
`$cfg['mysql']['db']` ชื่อฐานข้อมูล
จากนั้น ติดตั้งฐานข้อมูล โดยสร้างฐานข้อมูลเป็นตามชื่อที่คุณกำหนดไว้
import ไฟล์ ajax_chat_structure.sql ผ่านทาง phpmyadmin
เสร็จสิ้นขั้นตอนการติดตั้ง

**คำสั่งแชท**ต่างๆสำหรับ admin หรือผู้ใช้โปรดดูใน help.txt

---

### การเพิ่ม emoticon/smiley

ตัวสคริปที่หลายคนติดตั้งไปตัวนี้ ซึ่งบอกกันว่าไม่มี emoticon แต่จริงๆแล้วนั้นมีให้อยู่แล้ว
เพียงแต่ทำมาเป็นตัวอย่างให้เพียงอันเดียวเท่านั้น.
บทความนี้จะบอกรายระเอียดการเพิ่ม อักษรภาพด้วยตัวเอง


#### รายละเอียด

การแปลงข้อความเป็นอักษรภาพนั้น คำสั่งจะอยู่ในไฟล์ classes/addon.php ให้เปิดไฟล์นี้ขึ้นมา

เลื่อนลงไปดูที่ `public function emoticon($message)`
ไปที่ท้ายสุดของบรรทัดนี้ 
```{{{$output = str_replace(":)",html::img(_W_ROOT_.'images/emo/smile.gif','0',':)',array('title'=>'smile')),$message);}}}```
กด enter เพิ่มบรรทัดใหม่
copy บรรทัดโค้ดข้างบนมาวางในบรรทัดใหม่นี้

ทีนี้เรามาทำความเข้าใจกันก่อนว่าอะไรเป็นอะไร
```||$output = ||str_replace(||":)"||,html::img(||{{{_W_ROOT_.'images/emo/smile.gif','0',':)'}}}||,array('title'=>'smile'))||,$message||);||```
```||$output = ||str_replace(||"ตัวพิมพ์ยิ้ม"||,html::img(||{{{_W_ROOT_.'images/emo/ชื่อรูปยิ้ม.gif','0','ตัวพิมพ์ยิ้ม'}}}||,array('title'=>'ชื่อภาพ'))||,เปลี่ยนคำว่า $message ไปเป็น $output||);||```

**ไฟล์ emoticon เอาไว้ไหน?**
 ไฟล์ภาพ emoticon จะเอาไว้ที่ images/emo/ เท่านั้น


**ข้อควรระวัง**
ตรงคำว่า `$message` ในโค้ดแรกของ `function emoticon` นั้นไม่ต้องเปลี่ยน เปลี่ยนเฉพาะบรรทัดต่อๆมาเท่านั้น

ตัวอย่าง
จะใส่อักษรภาพ sad
```{{{$output = str_replace(":(",html::img(_W_ROOT_.'images/emo/sad.gif','0',':(',array('title'=>'sad')),$output);}}}```
จากตัวอย่างข้างบน ถ้าอัพโหลดอักษรภาพไว้ใน images/emo และนามสกุลไฟล์ถูกต้อง จะพบว่าเมื่อพิมพ์ :( จะกลายเป็นรูปภาพทันที
หรือจะใส่ภาพ happy
```{{{$output = str_replace(":D",html::img(_W_ROOT_.'images/emo/happy.gif','0',':D',array('title'=>'happy')),$output);}}}```
ก็จะออกมาเป็นภาพยิ้มตามภาพที่อัปโหลดไว้
