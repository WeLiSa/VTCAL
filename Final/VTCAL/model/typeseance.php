<?php

/**
Class representing the different sessions
**/
class typeseance{
	protected $name_typeseance;
	
	public function __construct($nametypes){
		$this->name_typeseance=$nametypes;
	}
	
	public function __destruct(){
	  $this->name_typeseance=null;
	}
	
	public function getNameTypeSeance(){
		return $this->name_typeseance;
	}
}

?>