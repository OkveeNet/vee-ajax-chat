<?php
/**
* define file คือไฟล์ที่ทำหน้าที่ระบุตัวแปรหลักของระบบ 
* กรุณาอย่าแก้ไขไฟล์นี้ถ้าไม่จำเป็น
*/

/* Improve PHP configuration to prevent issues */
//@ini_set('display_errors', 'off');
@ini_set('upload_max_filesize', '100M');
@ini_set('default_charset', 'utf-8');

/* Correct Apache charset */
header('Content-Type: text/html; charset=utf-8');

/* Set no cache */
header("Cache-Control: no-cache, must-revalidate");

/*time zone for correct time.*/
date_default_timezone_set('Asia/Bangkok');

/* Autoload */
function __autoload($className)
{
	if (!class_exists($className, false))
		if (file_exists(dirname(__FILE__).'/../classes/'.$className.'.php'))
			require_once(dirname(__FILE__).'/../classes/'.$className.'.php');
}// autoload

ob_start();//require for write cookies

/* load custom function */##########
include (dirname(__FILE__)."/functions.inc.php");

/* กำหนด path ต่างๆ */##########
define('_W_ADDRESS_',									$_SERVER['HTTP_HOST']);// ชื่อเว็บไม่มี  http:// เช่น domain.com, www.domain.com
define('_W_ROOT_PATH_',								realpath(currentDir().'/..'));// output is c:\path\to\site with no slash trail
define('_W_ROOT_',										$cfg['site']['rootpath']);//output /root/ (slash trail.) default value is $main_base;
define('_W_THIS_PATH_',								$explodePath[count($explodePath)-2]);// output is just 'site'
define('_W_THIS_PAGE_',								$explodePath[count($explodePath)-1]);// output is just 'file.php'
define('_W_LN_',											$cfg['site']['ln']);//en or th
/* theme */
define('_THEME_PATH_',									_W_ROOT_PATH_."/themes/".$cfg['theme']['name']."/");//output is c:\path\to\site\themes\name\
define('_THEME_',											_W_ROOT_."themes/".$cfg['theme']['name']."/");//output is /site/themes/name/
/* about user */
define('_U_IP_',												user_ip());
/* database */
define('_DBPRE_',											$cfg['mysql']['dbprefix']);//database prefix eg. chat_
define('_dbpre_',												_DBPRE_);//same as above
define('_W_MAGIC_QUOTES_GPC_',					get_magic_quotes_gpc());
define('_W_MYSQL_REAL_ESCAPE_STRING_',		function_exists('mysql_real_escape_string'));

/* connect to db */##########
include (dirname(dirname(__FILE__)).'/classes/adodb/adodb.inc.php');
$db = ADONewConnection('mysql');
$db->debug = false;
$db->Connect($cfg['mysql']['server'].":".$cfg['mysql']['port'], $cfg['mysql']['username'], $cfg['mysql']['password'], $cfg['mysql']['db']);
$db->execute("SET NAMES 'utf8'");
$db->execute("SET character_set_results=utf8");
$db->execute("SET character_set_client=utf8");
$db->execute("SET character_set_connection=utf8");

/* initial file */##########
include (dirname(__FILE__)."/init.inc.php");

?>