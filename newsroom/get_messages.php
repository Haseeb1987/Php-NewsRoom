<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';
$chatroom_id=1;
	show_messages($chatroom_id,$con);
?>
