<?php
	class Produit{
		private $ref;
		private $qte;
		private $images;
		private $prix;
		private $label;
		private $description;
		private $idCateg;
		private $noteMoy;
		function __construct($ref, $qte, $images, $prix, $label, $description, $idCateg, $noteMoy){
			$this->ref = $ref;
			$this->qte = $qte;
			$this->images = $images;
			$this->prix = $prix;
			$this->label = $label;
			$this->description = $description;
			$this->idCateg = $idCateg;
			$this->noteMoy = $noteMoy;
		}
		function getRef(){
			return $this->ref;
		}
		function getQte(){
			return $this->qte;
		}
		function getImage(){
			return $this->images;
		}
		function getPrix(){
			return $this->prix;
		}
		function getLabel(){
			return $this->label;
		}
		function getDesc(){
			return $this->description;
		}
		function getCateg(){
			return $this->idCateg;
		}
		function getNote(){
			return $this->noteMoy;
		}

		function setRef($ref){
			$this->ref = $ref;
		}
		function setQte($qte){
			$this->qte = $qte;
		}
		function setImage($images){
			$this->images = $images;
		}
		function setPrix($prix){
			$this->prix = $prix;
		}
		function setLabel($label){
			$this->label = $label;
		}
		function setDesc($description){
			$this->description = $description;
		}
		function setCateg($idCateg){
			$this->idCateg = $idCateg;
		}
		function setNote($noteMoy){
			$this->noteMoy = $noteMoy;
		}
	}
?>