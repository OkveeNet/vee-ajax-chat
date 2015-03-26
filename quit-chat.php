<?php
/**
* quit-chat ออกจากห้องแชท
*/
require (dirname(__FILE__)."/includes/config.inc.php");
/* content start */##########
$username = (isset($_COOKIE['username']) ? $_COOKIE['username'] : "");
$name = new name();
$name->name = $username;
if ($name->get_user_id() != false) {$user_id = $name->get_user_id();} else {$user_id = "0";}
//delete from name table
$sql = "delete from "._dbpre_."name where name_id = '".mydb::psql($user_id)."'";
$db->execute($sql);
//remove cookie
cookies::remove("username");
cookies::remove("password");
tools::redirect("./");
/* content end */##########
require (dirname(__FILE__)."/includes/endpage.php");
?>