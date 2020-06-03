<?php
	include "../../entities/Produit.php";
	include "../../core/ProduitC.php";
	if(isset($_POST['ref']) and isset($_POST['qte']) and isset($_POST['images']) and isset($_POST['prix']) and isset($_POST['label']) and isset($_POST['description']) and isset($_POST['idCateg']) and isset($_POST['noteMoy'])){
	$produit1 = new Produit($_POST['ref'], $_POST['qte'], $_POST['images'], $_POST['prix'], $_POST['label'], $_POST['description'], $_POST['idCateg'], $_POST['noteMoy']);
		$produit1C = new ProduitC();
		$produit1C->ajouterProduit($produit1);
		header('Location: afficherProduit.php');	
	}else{
		echo "Verifier les champs";
	}
?>