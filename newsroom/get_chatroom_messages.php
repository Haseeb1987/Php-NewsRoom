<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';
if(isset($_SESSION['Auth']['id'])){
	$chat_login_time=get_chat_login_time($_GET['user_id'],$con);
} else $chat_login_time="99999999999";
	if($_GET['load_old']=="no") get_chatroom_messages($_GET['id'],$chat_login_time,$con);
	else getall_chatroom_messages($_GET['id'],$con);
?>
