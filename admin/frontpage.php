<?php
	require_once 'admin_functions.php';
	adminInit();
?>
<article class="module width_full">
	<header><h3>Welcome <?php echo $user->name; ?></h3></header>
	<div class="module_content">
		<p>Welcome to the admin panel! Here you can edit all settings for this site.</p>
	</div>
</article>
<div class="module_content">
		<form id="update_password">
			<input type="hidden" name="form" value="update_password">
			<fieldset style="width:48%; float:left; margin-right: 3%;">
				<h3>Change your password</h3>
				<label>New Password</label>
				<input type="password" name="password">
				<div class="submit_link">
					<input type="submit" value="Update password" class="alt_btn">
				</div>
			</fieldset>
		</form>
	</div>
		<script type="text/javascript">
			$("#update_password").submit(function(){
				$(this).sendForm(function(o){
					$mainSection.alertInfo("Your password is now changed",$successBox);
				});
			});
		</script>