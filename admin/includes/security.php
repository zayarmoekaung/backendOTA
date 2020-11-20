<?php 
//session_start();


if (!in_array($_SESSION['user']['role'], ["Admin", "Author"])) {
	header('location: ../login.php');
}




?>