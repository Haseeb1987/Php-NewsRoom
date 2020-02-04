<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';

	if($_GET['current_private']=="0") show_online_users($_GET['place'],$con);
	else {}
?>
