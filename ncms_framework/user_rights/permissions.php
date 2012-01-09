<?php
class permissions{
	/**
	 *	@var array Contains the permissions related to the current object (typically a user).
	 */
	private $permissions;
	/**
	 *	@param int $user_id The objects id.
	 *	@param int $group_id The id of the group this object belongs too.
	 *	@param array $areas An array containing the areas this object needs to register access too.
	 */
	function __construct($user_id, $group_id, $areas){
		$this->permissions = $this->register($user_id, $group_id, $areas);
	}
	/**
	 *	Receiving parameters from the constructor.
	 */
	function register($user_id, $group_id, $areas){
		$crud = array("create", "read", "update", "delete");
		if(is_array($areas)){
			foreach ($areas as $area){
				$rows .= "pt_ur_areas.area='".$area."' OR ";
			}
			$rows = substr($rows, 0, -4);
		}elseif(is_string($areas)){
			$rows = "pt_ur_areas.area='".$areas."' ";
		}else{
			die("permissions:register() skal bruge enten en string eller et array som parameter! Du har desværre fejlet!? :S");
		}
		global $db;
		$query = $db->buildSelectQuery(
			"pt_ur_permissions",
			"pt_ur_permissions.*, pt_ur_areas.area",
			"(user_id=".$user_id." OR group_id=".$group_id.") AND (".$rows.") ORDER BY group_id DESC",
			array("pt_ur_areas", "inner", "pt_ur_permissions.area_id = pt_ur_areas.id")
		);

		$permission_result = $db->selectArray(
			"pt_ur_permissions",
			"pt_ur_permissions.*, pt_ur_areas.area",
			"(user_id=".$user_id." OR group_id=".$group_id.") AND (".$rows.") ORDER BY group_id DESC",
			array("pt_ur_areas", "inner", "pt_ur_permissions.area_id = pt_ur_areas.id")
		);
		
		$return_array = array();
		if(count($permission_result)>0){
			foreach($permission_result as $permission){
				$perm_area = $permission['area'];
				foreach($crud as $action){
					$return_array[$perm_area]["special"] = ($permission["user_id"] != NULL) ? true : false;
					if($permission[$action] != NULL){
						$return_array[$perm_area][$action] = $permission[$action];
					}
				}
			}
		}
		return $return_array;
	}
	function getPermissions($area=false){
		return ($area) ? $this->permissions[$area] : $this->permissions;
	}
	function canRead($area){
		if($this->permissions[$area]['read'] == 1){
			return true;
		}else{
			return false;
		}
	}
	function canCreate($area, $policy=true){
		if($this->permissions[$area]['create'] == 1){
			if($policy == true && $this->canRead($area) == false){
				return false;
			}
			return true;
		}else{
			return false;
		}
	}
	function canUpdate($area, $policy=true){
		if($this->permissions[$area]['update'] == 1){
			if($policy == true && $this->canCreate($area) == false){
				return false;
			}
			return true;
		}else{
			return false;
		}
	}
	function canDelete($area, $policy=true){
		if($this->permissions[$area]['delete'] == 1){
			if($policy == true && $this->canUpdate($area) == false){
				return false;
			}
			return true;
		}else{
			return false;
		}
	}
}
?>