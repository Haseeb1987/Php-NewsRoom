<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';

	checkname($_GET['name'],$con);
?>
