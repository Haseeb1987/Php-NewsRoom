<?php session_start();
include 'includes/functions.php';
include 'includes/DB.php';
//require_once 'includes/PasswordHash.php';
				$passdb=get_password($_GET['room'],$con);
				//$passHash = new PasswordHash(8, false);
				//$pwcheck = $passHash->CheckPassword($_GET['password'], $passdb);
				if($passdb==$_GET['password']) echo "correct"; else echo "not correct";
?>
