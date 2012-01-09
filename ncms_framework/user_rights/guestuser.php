<?php
class guestuser extends user{
	function __construct(){
		$this->id = 0;
		$this->group_id = 4;
		$this->name = "Guest";
	}
}