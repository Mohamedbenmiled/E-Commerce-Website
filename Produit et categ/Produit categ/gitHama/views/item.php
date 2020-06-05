<!DOCTYPE html>
<html>
	<head>
		<title>Veni Vidi</title>
		<link rel="stylesheet" type="text/css" href="../stylesheet.css">
	</head>

	<body>
		<div class="topBar">
			<table style="width: 95%; height: 100%">
				<tr>
					<td style="width: 71%; padding-left: 5%">
						<a class="venividi" href="index.php">Veni Vidi</a>
					</td>
					<td style="width: 6%" class="choixTd">
						<a class="choix" href="index.php">Home</a>
					</td>
					<td style="width: 6%" class="choixTd">
						<a class="choix" href="about.php">About</a>
					</td>
					<td style="width: 6%" class="choixTd">
						<a class="choix" href="contact.php">Contact</a>
					</td>
					<td style="width: 6%" class="choixTd">
						<a class="choix" href="products.php">Shop</a>
					</td>
					<td style="width: 6%">
						<a class="choix" href="cart.php">
							<img src="../images/cart.png" alt="Cart" class="cart">
							<?php 
								include "../config.php";
								include "../entities/ProduitCommande.php";
								include "../core/ProduitCommandeC.php";
								include('../core/AvisC.php');
								include('../entities/Avis.php');
								include('../core/ClientC.php');
								include('../entities/Client.php');
								$produitCommande1C = new ProduitCommandeC();
								$idClient = 1;
								$nb = $produitCommande1C->getNbCart($idClient);
							?>
							<label class="cartNb"><?php echo $nb;?></label>
						</a>
					</td>
				</tr>		
			</table>	
		</div>
		<?php 
			include("../entities/Event.php");
			include("../core/EventC.php");
			$eventC = new EventC();
			$date = date("Y/m/d H:i:s");
			$eventActuel = $eventC->recupererEventByDate($date);
			include("../core/RemiseC.php");
			include("../entities/Remise.php");
			$remiseC = new RemiseC();
			$onSale = false; 
			$tx = 0;
			if($eventActuel->rowCount() != 0){
				$eventActuel = $eventC->recupererEventByDate($date);
				foreach($eventActuel as $rowEvent){
					$remise = $remiseC->recupererRemise($_GET['ref'], $rowEvent['id']);
					if($remise->rowCount() != 0){
						$onSale = true; 
						foreach($remise as $rowRemise){
							$tx = $rowRemise['taux'];
						}	
					}
				}
			}
			include "../entities/Produit.php";
			include "../core/ProduitC.php";
			$produit1C = new ProduitC();
			$ref = $_GET['ref'];
			$sql = "SELECT * FROM Produit WHERE ref = $ref";
			$db = config::getConnexion();
			try{
				$product = $db->query($sql);
			}catch(Exception $e){
				die('Erreur: '.$e->getMessage());
				echo "</tr>";
			}
			foreach($product as $row){
				$idCateg = $row['idCateg'];
				$sql = "SELECT nom FROM Categories WHERE id = $idCateg";
				$db = config::getConnexion();
				try{
					$product = $db->query($sql);
				}catch(Exception $e){
					die('Erreur: '.$e->getMessage());
					echo "</tr>";
				}
			if(isset($_GET['success'])){
				if($_GET['success'] == true){
				?>
					<center style="padding-top: 20px;">	
						<div class="sucessAdd" align="left">
							<table style="width: 100%; height: 100%">
								<tr style="width: 100%; height: 100%">
									<td>
										<label class="checkmark">🗸</label>
										<label class="sucessText">“<?php echo $row['label'];?>” has been added to your cart.
									</td>
									<td align="right" style="padding-right: 20px;">
										<input type="button" value="VIEW CART" class="viewCartBtn" onclick="location.href='cart.php';">
									</td>		
								</tr>
							</table>
						</div>
					</center>
				<?php
				}
			}
		?>
		<table class="tableItem">
			<tr>
				<td class="itemLeft" valign="top">
					<table>
						<tr>
							<td>
								<label class="shopTop"> Home » Shop » Item </label>
							</td>
						</tr>
						<tr>
							<td height="735" width="550">
								<div class="mainImage" id="mainImg" style="background-image: url('../<?php echo $row['images']; ?>/0.png')">
								<?php
									if($onSale){
								?>
									<label class="salePrd">Sale!</label>
								<?php
									}
								?>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<table cellspacing="5px">
									<tr>
										<?php 
											for($i = 0; $i < 4; $i++){
												?>
												<td>
												<img src="../<?php echo $row['images'].'/'.$i; ?>.png" alt="image<?php echo $i;?>" class="subImage" onclick="changeImage(<?php echo "$i , $ref" ?>)" id="image<?php echo $i ?>">
												</td>
												<?php
											}
										?>
									</tr>	
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td class="itemRight" valign="top">
					<table cellspacing="25px">
						<tr>
							<td>
								<label class="itemTitle"><?php echo strtoupper($row['label']); ?></label>
							</td>	
						</tr>
						<tr>
							<td>
								<table>
									<tr>
										<td>
											<?php
											for($k = 0; $k < $row['noteMoy']; $k++){
												?><img src="../images/starFull.png" class="star"><?php	
											}	
											for($k = $row['noteMoy']; $k < 5; $k++){
												?><img src="../images/starEmpty.png" class="star"><?php
											}
											?>
										</td>
										<td>
											<?php 
												$sql = "SELECT COUNT(*) FROM Avis WHERE refProduit = $ref";
												$db = config::getConnexion();
												try{
													$count = $db->query($sql);
												}catch(Exception $e){
													die('Erreur: '.$e->getMessage());
													echo "</tr>";
												}
												foreach($count as $rowCount){
											?>
											<a href="#rev" class="customerReview">(<?php echo $rowCount['COUNT(*)'];}?> customer reviews)</a>	
										</td>
									</tr>
								</table>
							</td>	
						</tr>
						<tr>
							<td>
								<?php
									if($onSale){
								?>
								<label class="itemPriceSolde"><?php echo $row['prix']; ?> TND </label>
								<label class="itemPrice"><?php echo $row['prix']*$tx/100;?> TND</label>
								<?php
									}else{
								?>
								<label class="itemPrice"><?php echo $row['prix'];?> TND</label>
								<?php
									}
								?>
							</td>	
						</tr>
						<tr>
							<td>
								<p class="itemDesc"><?php echo $row['description'];?></p>
							</td>	
						</tr>
						<tr>
							<td>
								<form method="POST" action="crud/ajoutProduitCommande.php">
									<input type="number" step="1" pattern="\d+" min="1" name="qte" value="1" class="qteItem">
									<input type="hidden" name="idClient" value="<?php echo $idClient; ?>">
									<input type="hidden" name="refProd" value="<?php echo $ref; ?>">
									<input type="submit" value="ADD TO CART" class="addToCartButton">
								</form>
							</td>	
						</tr>
						<tr>
							<td>
								<label class="itemCateg">Category: </label>
								<?php foreach($product as $rowCat){?>
								<a href="products.php?idCateg=<?php echo $idCateg;?>" class="itemCateg2"><?php echo $rowCat['nom'];?></label>
								<input type="hidden" value="<?php echo $idCateg; ?>" name="idCateg">
								<?php } ?>
							</td>	
						</tr>
						<tr>
							<td>
							</td>	
						</tr>
					</table>
				</td>	
			</tr>
		</table>
		<?php
		}
		?>
		<div style="width: 100%" align="center">
			<div style="width: 84%; margin-bottom: 15px;" align="left">
				<label id="rev" class="reviewsTitle">Reviews (<?php echo $rowCount['COUNT(*)'];?>)</label>
			</div>	
			<table style="width: 84%; border-spacing:0 23px; margin-bottom: 20px;">
				<?php
					$avisC = new AvisC();
					$a = $avisC->recupereravis($ref);
					if($a->rowCount() == 0){
						?>
						<tr>
							<td>
								<label class="revMsg" style="font-style: italic">No reviews to show.</label>
							</td>	
						</tr>
						<?php
					}else{
						foreach($a as $rowAvis){
							$client = new ClientC();
							$cl = $client->recupererClient($rowAvis['idClient']);
							foreach($cl as $rowClient){
				?>
				<?php
					if($rowAvis['idClient'] == $idClient && isset($_GET['edit']) && $_GET['edit'] == true){
					?>
						<tr id="r<?php echo $rowClient['id'];?>">
							<td style="width: 4%;" valign="top" align="left">
								<img class="revPic" src="../images/picture.png" alt="Picture">
							</td>
							<td class="rightRev" style="width: 96%;">
								<form method="POST" action="crud/updateAvis.php">
									<label style="float: right;" class="rate" id="rateMini">
										<input type="radio" id="star5" name="rate" value="5" <?php if($rowAvis['note'] == 5){echo "checked";}?>>
										<label for="star5" title="text">5 stars</label>
										<input type="radio" id="star4" name="rate" value="4" <?php if($rowAvis['note'] == 4){echo "checked";}?>>
										<label for="star4" title="text">4 stars</label>
										<input type="radio" id="star3" name="rate" value="3" <?php if($rowAvis['note'] == 3){echo "checked";}?>>
										<label for="star3" title="text">3 stars</label>
										<input type="radio" id="star2" name="rate" value="2" <?php if($rowAvis['note'] == 2){echo "checked";}?>>
										<label for="star2" title="text">2 stars</label>
										<input type="radio" id="star1" name="rate" value="1" <?php if($rowAvis['note'] == 1){echo "checked";}?>>
										<label for="star1" title="text">1 star</label>
										<div>
											<input type="hidden" name="idClient" value="<?php echo $idClient;?>">
											<input type="hidden" name="ref" value="<?php echo $ref;?>">
											<input type="submit" name="save" value="💾" class="save" style="float: right">
										</div>
									</label>
									<label class="revName"><?php echo $rowClient['prenom'];?>&nbsp;</label>
									<label class="revDate" nom="date"> – &nbsp;<?php echo Date("F j, Y", strtotime($rowAvis['dateAvis']));?></label><br><br>
									<textarea class="editTxt" name="appreciation"><?php echo $rowAvis['appreciation'];?></textarea>
								</form>
							</td>
						</tr>
					<?php
						}else{
				?>
				<tr id="r<?php echo $rowClient['id'];?>">
					<td style="width: 4%;" valign="top" align="left">
						<img class="revPic" src="../images/picture.png" alt="Picture">
					</td>
					<td class="rightRev" style="width: 96%;">
						<label style="float: right;">
						<?php
							for($k = 0; $k < $rowAvis['note']; $k++){
								?><img src="../images/starFull.png" class="star"><?php	
							}	
							for($k = $rowAvis['note']; $k < 5; $k++){
								?><img src="../images/starEmpty.png" class="star"><?php
							}
						?>
						</label>
						<label class="revName"><?php echo $rowClient['prenom'];?>&nbsp;</label>
						<label class="revDate"> – &nbsp;<?php echo Date("F j, Y", strtotime($rowAvis['dateAvis']));?></label>
						<?php 
							if($rowAvis['idClient'] == $idClient){
						?>
						<form method="POST" action="crud/supprimerAvis.php">
							<input type="hidden" name="idClient" value="<?php echo $idClient;?>">
							<input type="hidden" name="refproduit" value="<?php echo $ref;?>">
							<input type="submit" name="supprimer" value="x" class="delete" style="float: right; margin-right: -85px; margin-top: 23px">
						</form>
						<form method="POST" action="item.php?ref=<?php echo $ref;?>&edit=true&#r<?php echo $idClient;?>">
							<input type="hidden" name="idClient" value="<?php echo $idClient;?>">
							<input type="hidden" name="refproduit" value="<?php echo $ref;?>">
							<input type="submit" value="♲" class="update" style="float: right; margin-right: -63px; margin-top: 23px" id="<?php echo $rowAvis['idClient'];?>">		
						</form>
						<?php 
							}
						}
						?>
						<p class="revMsg"><?php echo $rowAvis['appreciation'];?></p>
					</td>
				</tr>
				<?php
							}
						}
					}
				?>
			</table>
			<form method="POST" action="crud/ajoutAvis.php">
				<table align="center" class="revTable" cellspacing="12px">
					<tr>
						<td colspan="2" align="left">
							<label class="addReview">Add a review</label>
						</td>
					</tr>
					<?php 
						if($idClient != 0){
							$a = $avisC->recupereravisDeClient($idClient, $ref);
							if($a->rowCount() == 0){
					?>
					<tr>
						<td colspan="2" align="left">
							<label class="itemDesc">Your email address will not be published.</label>
						</td>
					</tr>
					<tr>
						<td style="width: 72px">
							<label class="itemDesc">Your rating</label>
						</td>
						<td class="rate">
							<input type="radio" id="star5" name="rate" value="5">
							<label for="star5" title="text">5 stars</label>
							<input type="radio" id="star4" name="rate" value="4">
							<label for="star4" title="text">4 stars</label>
							<input type="radio" id="star3" name="rate" value="3">
							<label for="star3" title="text">3 stars</label>
							<input type="radio" id="star2" name="rate" value="2">
							<label for="star2" title="text">2 stars</label>
							<input type="radio" id="star1" name="rate" value="1">
							<label for="star1" title="text">1 star</label>
						</td>	
					</tr>
					<tr>
						<td colspan="2">
							<label class="itemDesc">Your review *</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<textarea class="revText" id="revText" name="appreciation"></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="idClient" value="<?php echo $idClient;?>">
							<input type="hidden" name="ref" value="<?php echo $ref;?>">
							<input type="submit" value="REVIEW" class="revBtn">
						</td>
					</tr>
				<?php 
						}else{
							?>
							<tr>
								<td colspan="2">
									<label class="itemDesc" style="font-style: italic">You have already reviewed this product.</label>
								</td>
							</tr>
							<?php
						}
					}else{ ?>
					<tr>
						<td colspan="2">
							<label class="itemDesc" style="font-style: italic">You must be logged in.</label>
						</td>
					</tr>
				<?php } ?>
				</table>
			</form>
		</div>
		<div class="prdBottomImg">
		</div>
		<script type="text/javascript">
			document.getElementById("image0").className = "subImageCurrent";
			function changeImage(i, ref){
    			document.getElementById("mainImg").style.backgroundImage = "url(../images/products/" + ref + "/" + i + ".png)";
    			for(j = 0; j < 4; j++){
    				document.getElementById("image" + j).className = "subImage";
    			}
    			document.getElementById("image" + i).className = "subImageCurrent";
			}
		</script>
	</body>
</html>