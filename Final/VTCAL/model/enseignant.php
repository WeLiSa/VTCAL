<?php
/**
Class representing different teachers
**/
class enseignant{
	protected $name_enseignant;
	protected $groupeetudiants;
	
	public function __construct($nameenseignant){
		$this->name_enseignant=$nameenseignant;
		$this->groupeetudiants=array();
	}
	
	public function __destruct(){
	  $this->name_enseignant=null;
	  $this->groupeetudiants=null;
	}
	
	public function getNameEnseignant(){
		return $this->name_enseignant;
	}
	
	public function addGroupeEtudiant($getudiant){
		$this->groupeetudiants[]=$getudiant;
	}
	
	public function getGroupeEtudiant(){
	
		return $this->groupeetudiants;
	}
}

?>