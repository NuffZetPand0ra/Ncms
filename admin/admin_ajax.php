<?php
require_once '../../external/nzp_mysql_calls/mysql_calls.php';
require_once '../../internal/config/settings.php';
require_once '../../internal/login.php';
require_once '../../internal/user_rights/user.php';
require_once '../../internal/func_lib.php';
session_start();
$user = $_SESSION['user'];
$db = new db(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
switch($_POST['form']){
	default:
		$response['answer'] = "Define form please";
		break;
	case "edit_users":
		$response['answer'] = "Editing users";
		break;
	case "paid_status":
		$status = $_POST['status'];
		$time = (int)$status === 1 ? "'".date("Y-m-d H:i:s")."'" : "NULL";
		$updated_row_count = $db->updateQuery("pt_withdraw_requests", "status='$status', paid_date=$time", "id=".$_POST['id']);
		if($updated_row_count>0){
			$response['success'] = 1;
			$response['paid_time'] = $time=="NULL" ? "" : substr($time, 1, -1);
		}else{
			$response['success'] = -1;
		}
		break;
	case "ban_users":
		$id = $_POST['id'];
		$updated_row_count = $db->updateQuery("pt_users", "confirmed=-1", "id=".$_POST['id']);
		if($updated_row_count>0){
			$response['success'] = 1;
			$response['user'] = "banned";
		}else{
			$response['success'] = -1;
		}
		break;
	case "unban_users":
		$id = $_POST['id'];
		$updated_row_count = $db->updateQuery("pt_users", "confirmed=1", "id=".$_POST['id']);
		if($updated_row_count>0){
			$response['success'] = 1;
			$response['user'] = "unbanned";
		}else{
			$response['success'] = -1;
		}
		break;
	case "update_password":
		$password = $_POST['password'];
		$salt = rlyUniqId();
		$password = sha1($password.$salt);
		$updated_row_count = $db->updateQuery("pt_users", "password='".$password."', salt='".$salt."'", "id=".$user->id);
		if($updated_row_count>0){
			$response['success'] = 1;
			$response['user'] = "Your password is now changed";
		}else{
			$response['success'] = -1;
		}
		break;
	case "update_categories":
		$confirm = ($_POST['check']==1)? 1 : -1;
		$updated_row_count = $db->updateQuery("pt_categories", "confirmed=".$confirm, "id=".$_POST['id']);
		if($updated_row_count>0){
			$response['success'] = 1;
			$response['category'] = ($confirm==1)?$_POST['name']." accepted" : $_POST['name']." declined";
		}else{
			$response['success'] = -1;
			$response['category'] = "fail";
		}
		break;
	case "admin_profit":
		if($db->updateQuery("pt_options", "value='".$_POST['profit_rate']."'", "name='admin_profit'")){
			$response['success'] = 1;
			$response['profit_rate'] = $_POST['profit_rate'];
		}else{
			$response['success'] = -1;
		}
		break;
	case "teaser_length":
		if($db->updateQuery("pt_options", "value='".$_POST['teaser_length']."'", "name='teaser_duration'")){
			$response['success'] = 1;
			$response['duration'] = $_POST['teaser_length'];
		}else{
			$response['success'] = -1;
		}
		break;
}
/*if(count($_POST)>0){
	$response = $_POST;
	$response['from_server'] = "true";
}else{
	$response['alert'] = "Please define post data";
}*/
header('Content-type: application/json');
echo json_encode($response);
?>