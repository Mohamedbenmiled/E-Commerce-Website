<?php
	include "../../entities/Categorie.php";
	include "../../core/CategorieC.php";
	if(isset($_POST['id']) and isset($_POST['nom'])){
	$categorie1 = new Categorie($_POST['id'], $_POST['nom']);
		$categorie1C = new CategorieC();
		$categorie1C->ajouterCategorie($categorie1);
		header('Location: afficherCategorie.php');	
	}else{
		echo "Verifier les champs";
	}
?>