<?php
	class Categorie{
		private $id;
		private $nom;
		function __construct($id, $nom){
			$this->id = $id;
			$this->nom = $nom;
		}
		function getId(){
			return $this->id;
		}
		function getNom(){
			return $this->nom;
		}
		function setId($id){
			$this->id = $id;
		}
		function setNom($nom){
			$this->nom = $nom;
		}
	}
?>