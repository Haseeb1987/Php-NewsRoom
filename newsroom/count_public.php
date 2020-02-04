<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';

	count_public($_GET['total_public'],$con);
?>
