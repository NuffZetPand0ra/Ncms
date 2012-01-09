<?php
require_once 'init.php';
if(!isset($_GET['username'])){
	$user = new guestuser();
}else{
	$userdata = $db->selectArray(
		"ur_users",
		"ur_users.*, ur_groups.id AS group_id",
		"ur_users.name='".$_GET['username']."'",
		array("ur_groups", "inner", "ur_users.group_id=ur_groups.id")
	);
	//var_dump($userdata);
	if(count($userdata) == 1){
		$userdata = $userdata[0];
		$user = new user($userdata['id'], $userdata['group_id'], $userdata['name']);
	}else{
		die("Ingen brugere med det navn! <a href='".$_SERVER['PHP_SELF']."'>Prøv igen?</a>");
	}
}
$access = array("post", "thread", "frontpage");
$user->registerPermissions($access);

?>
<html>
<head>
</head>
<body>
	<form method="get">
		<input type="text" name="username" />
		<input type="submit" />
	</form>
	<pre><?php var_dump($user); ?></pre>
</body>
</html>