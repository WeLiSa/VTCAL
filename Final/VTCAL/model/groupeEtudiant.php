<?php
/**

Class representing different group of students

**/
class groupeEtudiant{
	protected $name_getudiant;
	protected $matieres;
	
	public function __construct($ngetudiant){
		$this->name_getudiant=$ngetudiant;
		$this->matieres=array();
	}
	
	public function __destruct(){
	  $this->name_getudiant=null;
	  $this->matieres=null;
	}
	
	public function getNameGroupeEtudiant(){
		return $this->name_getudiant;
	}
	
	public function addMatiere($matiere){
		$this->matieres[]=$matiere;
	}
	
	public function getMatieres(){
	
		return $this->matieres;
	}
}

?>