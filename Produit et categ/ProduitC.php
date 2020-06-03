<?php
	//include "../../config.php";
	class ProduitC{
		function afficherProduit($produit){
			echo "Reference: ".$produit->getRef()."<br>";
			echo "Label: ".$produit->getLabel()."<br>";
			echo "Quant: ".$produit->getQte()."<br>";
			echo "Description: ".$produit->getDesc()."<br>";
			echo "Prix: ".$produit->getPrix()."<br>";
			echo "Image: ".$produit->getImage()."<br>";
			echo "Categories: ".$produit->getCateg()."<br>";
			echo "Note moyenne: ".$produit->getNote()."<br>";
		}
		function ajouterProduit($produit){
			$sql = "INSERT INTO Produit(ref, qte, images, prix, label, description, idCateg, noteMoy) values(:ref, :qte, :images, :prix, :label, :description, :idCateg, :noteMoy)";
			$db = config::getConnexion();
			try{
		       	$req = $db->prepare($sql);
		       	$ref = $produit->getRef();
		       	$label = $produit->getLabel();
		        $qte = $produit->getQte();
		        $description = $produit->getDesc();
		        $prix = $produit->getPrix();
		        $images = $produit->getImage();
				$noteMoy= $produit->getNote();
				$idCateg= $produit->getCateg();
		        $req->bindValue(':ref', $ref);
		        $req->bindValue(':qte', $qte);
				$req->bindValue(':images', $images);
				$req->bindValue(':prix', $prix);
				$req->bindValue(':label', $label);
				$req->bindValue(':description', $description);
				$req->bindValue(':idCateg', $idCateg);
				$req->bindValue(':noteMoy', $noteMoy);
		        $req->execute(); 
		    }catch(Exception $e){
		        echo 'Erreur: '.$e->getMessage();
		    }
		}
		function afficherProduits(){
			$sql = "SELECT * FROM Produit";
			$db = config::getConnexion();
			try{
				$liste = $db->query($sql);
				return $liste;
			}catch(Exception $e){
		        die('Erreur: '.$e->getMessage());
		    }	
		}
		function supprimerProduit($ref){
			$sql = "DELETE FROM Produit where ref = :ref";
			$db = config::getConnexion();
		    $req = $db->prepare($sql);
			$req->bindValue(':ref', $ref);
			try{
		        $req->execute();
		    }catch(Exception $e){
		        die('Erreur: '.$e->getMessage());
		    }
		}
		function modifierProduit($produit, $ref){
			$sql = "UPDATE Produit SET ref = :refNew, qte = :qte, images = :images,  prix = :prix, label = :label, description = :description, idCateg = :idCateg, noteMoy =:noteMoy WHERE ref = :ref";
			$db = config::getConnexion();
			try{
		        $req = $db->prepare($sql);
				$refNew = $produit->getRef();
				$qte = $produit->getQte();
		        $images = $produit->getImage();
		        $prix = $produit->getPrix();
		        $label = $produit->getLabel();
		       	$description = $produit->getDesc();
				$idCateg = $produit->getCateg();
				$noteMoy = $produit->getNote();
				$datas = array(':refNew' => $refNew, ':qte' => $qte, ':images'=>$images, ':prix'=>$prix, ':label' => $label, ':description'=>$description, ':idCateg' =>$idCateg, ':noteMoy' =>$noteMoy);
				$req->bindValue(':refNew', $refNew);
				$req->bindValue(':qte', $qte);
				$req->bindValue(':images', $images);
				$req->bindValue(':prix', $prix);
				$req->bindValue(':label', $label);
				$req->bindValue(':description', $description);
				$req->bindValue(':idCateg', $idCateg);
				$req->bindValue(':noteMoy', $noteMoy);
				$req->bindValue(':ref', $ref);
		        $s = $req->execute();
		    }catch(Exception $e){
		        echo " Erreur ! ".$e->getMessage();
		   		echo " Les datas : " ;
		  		print_r($datas);
		    }	
		}
		function recupererProduit($ref){
			$sql = "SELECT * FROM Produit where ref = $ref";
			$db = config::getConnexion();
			try{
				$liste = $db->query($sql);
				return $liste;
			}   catch (Exception $e){
		        die('Erreur: '.$e->getMessage());
		    }
		}
		function updateNoteMoy($noteMoy, $ref){
			$sql = "UPDATE Produit SET noteMoy = $noteMoy WHERE ref = $ref";
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