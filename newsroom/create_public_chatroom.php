<?php
include 'includes/functions.php';
include 'includes/DB.php';

	$user_id=$_GET['user_id'];
	$text = $_POST['text'];
	$desc = $_POST['description'];
	create_public_chatroom($user_id,$text,$desc,$con);
?>
 