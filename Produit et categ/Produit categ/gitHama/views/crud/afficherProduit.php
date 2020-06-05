<?php
    include "../../core/ProduitC.php";
    $produit1C = new ProduitC();
    $listeProduits = $produit1C->afficherProduits();
?>

<table border="1">
    <tr>
        <td>Reference</td>
        <td>Label</td>
        <td>Quantiter</td>
        <td>Prix</td>
        <td>Image</td>
        <td>Description</td>
	<td>Categorie</td>
	<td>Note Moyenne</td>
        <td>Supprimer</td>
        <td>Modifier</td>
    </tr>
    <?php
    	foreach($listeProduits as $row){
    ?>
    <tr>
        <td><?php echo $row['ref']; ?></td>
        <td><?php echo $row['label']; ?></td>
        <td><?php echo $row['qte']; ?></td>
        <td><?php echo $row['prix']; ?></td>
        <td><?php echo $row['images']; ?></td>
        <td><?php echo $row['description']; ?></td>
	<td><?php echo $row['idCateg']; ?></td>
	<td><?php echo $row['noteMoy']; ?></td>
        <td>
        	<form method="POST" action="supprimerProduit.php">
	            <input type="submit" name="supprimer" value="Supprimer">
	            <input type="hidden" value="<?php echo $row['ref']; ?>" name="ref">
            </form>
        </td>
        <td>
        	<a href="modifierProduit.php?ref=<?php echo $row['ref']; ?>">
            Modifier</a></td>
    </tr>
    <?php
    	}
    ?>
</table>