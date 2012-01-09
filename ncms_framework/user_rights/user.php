<?php
class user{
	public $id;
	public $name;
	protected $group_id;
	protected $permissions;
	function __construct($user_id, $group_id, $name=""){
		$this->id = $user_id;
		$this->group_id = $group_id;
		$this->name = $name;
	}
	function registerPermissions($areas){
		$this->permissions = new permissions($this->id, $this->group_id, $areas);
	}
	function __get($name){
		return $this->$name;
	}
}
?>