<?php 

header("Content-type:text/html;charset=utf-8");

include("config.php");
include("conn.php");

$table = $db_pre . "advert";

if(!isset($_POST["submit"])){exit("非法访问!");}
$submit = htmlspecialchars($_POST["submit"]);

if($submit == "get_load"){
	$array = array();
	$result = mysql_query("select * from $table where type='load' group by id desc");
	while($rows = mysql_fetch_array($result,MYSQL_ASSOC)){
		$array[] = $rows;
	}
	echo json_encode($array);
	exit;
}

if($submit == "get"){
	$array = array();
	$result = mysql_query("select * from $table");
	while($rows = mysql_fetch_array($result,MYSQL_ASSOC)){
		$array[] = $rows;
	}
	echo json_encode($array);
	exit;
}

exit;

?>