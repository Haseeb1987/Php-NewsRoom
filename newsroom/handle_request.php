<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';
	handle_request($_GET['user_id'],$_GET['id'],$_GET['action'],$con);
?>
