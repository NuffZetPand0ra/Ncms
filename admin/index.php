<?php
require_once '../config.php';
require_once SERVER_ROOT.'/ncms_framework/user_rights/login.php';
require_once SERVER_ROOT.'/ncms_framework/user_rights/user.php';
session_start();
// if(count($_SESSION['user'])>0){
	// $user = $_SESSION['user'];
	// if($_SESSION['user']->group_id>1){
		// header("location: /index.php");
		// die();
	// }
// }else{
	// header("location: ".HTTP_ROOT."/index.php");
// }
$page_title = "Admin frontpage";
include 'admin_top.php';
include 'admin_bottom.php';
?>