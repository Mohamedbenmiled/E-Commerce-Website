<html>
	<head>
	</head>

	<body>
		<?php
			include "../../entities/Produit.php";
			include "../../core/ProduitC.php";
			if(isset($_GET['ref'])){
				$produitC = new ProduitC();
			    $result = $produitC->recupererProduit($_GET['ref']);
				foreach($result as $row){
					$ref = $row['ref'];
					$qte = $row['qte'];
					$images = $row['images'];
					$prix = $row['prix'];
					$label = $row['label'];
					$description = $row['description'];
					$idCateg = $row['idCateg'];
					$noteMoy = $row['noteMoy'];
		?>
		<form method="POST">
			<table>
				<caption>Modifier Produit</caption>
				<tr>
					<td>Reference</td>
					<td><input type="number" name="ref" value="<?php echo $ref ?>"></td>
				</tr>
				<tr>
					<td>Label</td>
					<td><input type="text" name="label" value="<?php echo $label ?>"></td>
				</tr>
				<tr>
					<td>Quantiter</td>
					<td><input type="text" name="qte" value="<?php echo $qte ?>"></td>
				</tr>
				<tr>
					<td>Description</td>
					<td><input type="text" name="description" value="<?php echo $description ?>"></td>
				</tr>
				<tr>
					<td>Prix</td>
					<td><input type="number" step="0.01" name="prix" value="<?php echo $prix ?>"></td>
				</tr>
				<tr>
					<td>Image</td>
					<td><input type="text" name="images" value="<?php echo $images ?>"></td>
				</tr>
				<tr>
					<td>Categorie</td>
					<td><input type="number" name="idCateg" value="<?php echo $idCateg ?>"></td>
				</tr>
				<tr>
					<td>Note moyenne</td>
					<td><input type="number" name="noteMoy" value="<?php echo $noteMoy ?>"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="modifier" value="Modifier"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="hidden" name="ref_ini" value="<?php echo $_GET['ref'];?>"></td>
				</tr>
			</table>
		</form>
		<?PHP
				}
			}
			if(isset($_POST['modifier'])){
			$produit = new Produit($_POST['ref'], $_POST['qte'], $_POST['images'], $_POST['prix'], $_POST['label'], $_POST['description'], $_POST['idCateg'], $_POST['noteMoy']);
				$produitC->modifierProduit($produit, $_POST['ref_ini']);
				echo $_POST['ref_ini'];
				header('Location: afficherProduit.php');
			}
		?>
	</body>
</html>