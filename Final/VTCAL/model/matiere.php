<?php
/**
Class representing the different courses
**/
class matiere{
	protected $name_matiere;
	protected $typesseance;
	
	public function __construct($nmatiere){
		$this->name_matiere=$nmatiere;
		$this->typeseance=array();
	}
	
	public function __destruct(){
	  $this->name_matiere=null;
	  $this->typesseance=null;
	}
	
	public function getNameMatiere(){
		return $this->name_matiere;
	}
	
	public function addTypeSeance($typeseance){
		$this->typesseance[]=$typeseance;
	}
	
	public function getTypeSeances(){
	
		return $this->typesseance;
	}
}

?>