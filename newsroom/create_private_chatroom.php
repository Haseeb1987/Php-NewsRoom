<?php
include 'includes/functions.php';
include 'includes/DB.php';

	$user_id=$_GET['user_id'];
	$text = $_POST['text'];
$desc = $_POST['description'];
$private_password = $_POST['private_password'];
	create_private_chatroom($user_id,$_POST['users'],$text,$desc,$private_password,$con);
?>
 