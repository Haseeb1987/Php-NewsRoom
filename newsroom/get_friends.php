<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';

	show_friends($_GET['user_id'],$con);
?>
