<?php
include 'includes/functions.php';
include 'includes/DB.php';

	$user_id=$_GET['user_id'];
	$text = $_POST['text'];
	insert_message_to_db($_POST['chatroom_id'],$user_id,$text,$con);
?>
 