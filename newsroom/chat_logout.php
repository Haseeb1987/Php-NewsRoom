<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';
if($_GET['user_id']!="0" &&$_GET['user_id']!=""){
	/*$name = get_username($_GET['user_id'],$con);
	$text=$name." has left the room";
	insert_message_to_db('1',$_GET['user_id'],$text,$con);*/
	chat_logout($_GET['user_id'],$con);
}
//session_destroy();
?>
