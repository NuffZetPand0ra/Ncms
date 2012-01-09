<?php
require_once $_SERVER['DOCUMENT_ROOT'].'../internal/login.php';
require_once $_SERVER['DOCUMENT_ROOT'].'../internal/user_rights/user.php';
session_start();
if(count($_SESSION['user'])>0){
	$user = $_SESSION['user'];
	if($_SESSION['user']->group_id>1){
		header("location: /index.php");
		die();
	}
}else{
	header("location: /index.php");
}
$page_title = "Admin frontpage";
include 'admin_top.php';
include 'admin_bottom.php';
?>