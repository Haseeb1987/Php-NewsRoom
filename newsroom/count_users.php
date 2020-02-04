<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';

	count_users($_GET['total_online'],$con);
?>
