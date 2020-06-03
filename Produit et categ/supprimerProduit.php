<?php
	include "../../core/ProduitC.php";
	$produitC = new ProduitC();
	if(isset($_POST["ref"])){
		$produitC->supprimerProduit($_POST["ref"]);
		header('Location: afficherProduit.php');
	}
?>