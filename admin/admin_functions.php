<?php
function adminInit(){
	global $user;
	require_once '../config.php';
	require_once SERVER_ROOT.'/ncms_framework/user_rights/login.php';
	require_once SERVER_ROOT.'/ncms_framework/user_rights/user.php';
	session_start();
}
?>