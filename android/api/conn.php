<?php 

date_default_timezone_set ('Asia/Shanghai');

header("Content-type:text/html;charset=utf-8");

include("config.php");

$conn = mysql_connect("$db_address","$db_username","$db_password") or die("数据库链接错误".mysql_error());

mysql_select_db("$db_name",$conn) or die("数据库访问错误".mysql_error());

mysql_query("SET NAMES 'UTF8'");

?>