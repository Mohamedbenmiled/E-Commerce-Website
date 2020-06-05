<?php
    include "../../core/CategorieC.php";
    $categorie1C = new CategorieC();
    $listeCategorie = $categorie1C->afficherCategories();
?>

<table border="1">
    <tr>
        <td>Id</td>
        <td>Nom</td>
        <td>Supprimer</td>
        <td>Modifier</td>
    </tr>
    <?php
    	foreach($listeCategorie as $row){
    ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['nom']; ?></td>
        <td>
        	<form method="POST" action="supprimerCategorie.php">
	            <input type="submit" name="supprimer" value="Supprimer">
	            <input type="hidden" value="<?php echo $row['id']; ?>" name="id">
            </form>
        </td>
        <td>
        	<a href="modifierCategorie.php?id=<?php echo $row['id']; ?>">
            Modifier</a></td>
    </tr>
    <?php
    	}
    ?>
</table>