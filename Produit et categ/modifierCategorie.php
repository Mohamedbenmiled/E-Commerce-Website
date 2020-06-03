<html>
	<head>
	</head>

	<body>
		<?php
			include "../../entities/Categorie.php";
			include "../../core/CategorieC.php";
			if(isset($_GET['id'])){
				$categorieC = new CategorieC();
			    $result = $categorieC->recupererCategorie($_GET['id']);
				foreach($result as $row){
					$id = $row['id'];
					$nom = $row['nom'];

		?>
		<form method="POST">
			<table>
				<caption>Modifier Categorie</caption>
				<tr>
					<td>Id</td>
					<td><input type="number" name="id" value="<?php echo $id ?>"></td>
				</tr>
				<tr>
					<td>Nom</td>
					<td><input type="text" name="nom" value="<?php echo $nom ?>"></td>
				</tr>
				
				<tr>
					<td></td>
					<td><input type="submit" name="modifier" value="Modifier"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="hidden" name="id_ini" value="<?php echo $_GET['id'];?>"></td>
				</tr>
			</table>
		</form>
		<?PHP
				}
			}
			if(isset($_POST['modifier'])){
			$categorie = new Categorie($_POST['id'], $_POST['nom']);
				$categorieC->modifierCategorie($categorie, $_POST['id_ini']);
				echo $_POST['id_ini'];
				header('Location: afficherCategorie.php');
			}
		?>
	</body>
</html>