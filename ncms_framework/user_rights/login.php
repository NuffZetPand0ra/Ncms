<?php
	class login{
		private $email;
		private $password;
		public $authenticated = false;
		public $user;
		/**
		*	@param string $email The email entered by client.
		*	@param string $password The email entered by client.
		*	@param bool $authenticate Wether constructor should authenticate the user (defaults to false).
		*/
		function __construct($email, $password, $authenticate = false){
			$this->email = $email;
			$this->password = $password;
			if($authenticate){$this->authenticate();}
		}
		/**
		*	@param bool $encrypt_password Set to false if you don't want the function to encrypt the password along with the salt from the database. Defaults to true.
		*	@return bool True if authentication succeeded, false if it didn't.
		*/
		function authenticate($encrypt_password = true){
			global $db;
			$salt = $db->selectRow("pt_users", "salt", "email = '".$this->email."'");
			$password = ($encrypt_password) ? sha1($this->password.$salt['salt']) : $this->password;
			$user_data = $db->selectArray(
				"pt_users",
				"id, username, group_id, confirmed",
				"email = '".$this->email."' AND password = '".$password."'"
			);
			if(count($user_data) != 1){return false;}
			$confirm = $user_data[0]['confirmed'];
			if(!is_bool($confirm) && $confirm == 1){
				$this->authenticated = true;
				$this->user = new user($user_data[0]['id'], $user_data[0]['group_id'], $user_data[0]['username'], $user_data[0]['confirmed']);
				return true;
			}
			return (int)$confirm;
		}
	}
	/**/
?>