<?php
	//include "../../config.php";
	class CategorieC{
		function afficherCategorie($categorie){
			echo "Id: ".$categorie->getId()."<br>";
			echo "Nom: ".$categorie->getNom()."<br>";
		}
		function ajouterCategorie($categorie){
			$sql = "INSERT INTO Categories(id, nom) values(:id, :nom)";
			$db = config::getConnexion();
			try{
		       	$req = $db->prepare($sql);
		       	$id = $categorie->getId();
		       	$nom = $categorie->getNom();
		     
		        $req->bindValue(':id', $id);
		        $req->bindValue(':nom', $nom);
				$req->execute(); 
		    }catch(Exception $e){
		        echo 'Erreur: '.$e->getMessage();
		    }
		}
		function afficherCategories(){
			$sql = "SELECT * FROM Categories";
			$db = config::getConnexion();
			try{
				$liste = $db->query($sql);
				return $liste;
			}catch(Exception $e){
		        die('Erreur: '.$e->getMessage());
		    }	
		}
		function supprimerCategorie($id){
			$sql = "DELETE FROM Categories where id = :id";
			$db = config::getConnexion();
		    $req = $db->prepare($sql);
			$req->bindValue(':id', $id);
			try{
		        $req->execute();
		    }catch(Exception $e){
		        die('Erreur: '.$e->getMessage());
		    }
		}
		function modifierCategorie($categorie, $id){
			$sql = "UPDATE Categories SET id = :idNew, nom = :nom WHERE id = :id";
			$db = config::getConnexion();
			try{
		        $req = $db->prepare($sql);
				$idNew = $categorie->getId();
				$nom = $categorie->getNom();

				$datas = array(':idNew' => $idNew, ':nom' => $nom);
				$req->bindValue(':idNew', $idNew);
				$req->bindValue('nom', $nom);
				$req->bindValue(':id', $id);
		        $s = $req->execute();
		    }catch(Exception $e){
		        echo " Erreur ! ".$e->getMessage();
		   		echo " Les datas : " ;
		  		print_r($datas);
		    }	
		}
		function recupererCategorie($id){
			$sql = "SELECT * FROM Categories where id = $id";
			$db = config::getConnexion();
			try{
				$liste = $db->query($sql);
				return $liste;
			}   catch (Exception $e){
		        die('Erreur: '.$e->getMessage());
		    }
		}
	}
?>