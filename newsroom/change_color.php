<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';

	change_color($_GET['user_id'],$_POST['color'],$con);
?>
