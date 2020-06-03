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
			include "../entities/Produit.php";
			include "../core/ProduitC.php";
			include "../core/ClientC.php";
			$client1C = new ClientC();
			$produit1C = new ProduitC();
			if(isset($_GET['idCateg'])){
				$idCateg = $_GET['idCateg'];
				$sql = "SELECT * FROM Produit WHERE idCateg = $idCateg";
				$db = config::getConnexion();
				try{
					$liste = $db->query($sql);
				}catch(Exception $e){
					die('Erreur: '.$e->getMessage());
					echo "</tr>";
				}	
			}else{
				$liste = $produit1C->afficherProduits();
			}
		?>
		<table class="productTable">
			<tr>
				<td class="left" align="center" valign="top">
					<table>
						<tr>
							<td style="padding-bottom: 13px;">
								<label class="prTitle">SEARCH</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" placeholder="Search products..." class="search">
							</td>
						</tr>	
						<tr>
							<td style="padding-bottom: 5px;"><br><br>
								<label class="prTitle">PRODUCT CATEGORIES</label>
							</td>
						</tr>	
						<?php 
							include "../entities/Categorie.php";
							include "../core/CategorieC.php";
							$produitC = new CategorieC();
							$listeCat = $produitC->afficherCategories();
							foreach($listeCat as $row){
							?>
							<tr>
								<td style="padding-top: 8px;">
									<form method="POST" action="products.php?idCateg=<?php echo $row['id'];?>">
							            <a href="products.php?idCateg=<?php echo $row['id'];?>" class="categorie"><?php echo $row['nom']; ?></a>
							            <input type="hidden" value="<?php echo $row['id']; ?>" name="idCateg">
						            </form>		
								</td>
							</tr>
						<?php 
						}
						?>
						<tr>
							<td style="padding-top: 60px;">
								<label class="prTitle">RECENT REVIEWS</label>
							</td>
						</tr>
						<tr>
							<td>
						<?php
							include "../core/AvisC.php";
							$AvisC = new AvisC();
							$listeAvis = $AvisC->afficherAvis();
						 	$count = 0;
							foreach($listeAvis as $rowAvis){
							    $count++;
							    if($count < 7){
							    	?>
							    	<table class="oneReview">
								    	<tr>
								    		<td class="reviewsLeft">
								    			<table>
								    				<tr>
								    					<td>
								    						<?php
								    						$prd = $produit1C->recupererProduit($rowAvis['refProduit']);
								    						foreach($prd as $p){
								    							?><label class="rvPrdTitle"><?php echo $p['label']; ?></label><?php
								    						}	
								    						?>
								    					</td>	
								    				</tr>
								    				<tr>
								    					<td>
								    						<?php
									    						for($i = 0; $i < $rowAvis['note']; $i++){
																	?><img src="../images/starFull.png" class="star"><?php	
																}	
																for($i = $rowAvis['note']; $i < 5; $i++){
																?><img src="../images/starEmpty.png" class="star"><?php
																}
															?>
								    					</td>	
								    				</tr>
								    				<tr>
								    					<td>
								    						<?php
								    						$client = $client1C->recupererClient($rowAvis['idClient']);
								    						foreach($client as $c){
								    							?><label class="rvPrdName">by <?php echo $c['prenom']; ?></label><?php
								    						}	
								    						?>
								    					</td>	
								    				</tr>
								    			</table>
								    		</td>
								    		<td class="reviewsRight" valign="top">
								    			<?php
								    			$prd = $produit1C->recupererProduit($rowAvis['refProduit']);
								    			foreach($prd as $p){
								    				?><img src="../<?php echo $p['images']; ?>/0.png" alt="productIcon" class="rvPrdIcon"><?php
								    			}	
								    			?>			
								    		</td>
								    	</tr>
									</table>
									<?php
							    }
							}
						?>
							</td>		
						</tr>
					</table>
				</td>
				<td class="right" valign="top" style="padding-top: 20px;">
					<table align="center" style="width: 83%">
						<tr>
							<td style="width: 50%">
								<label class="shopTop"> Home » Shop </label>
							</td>
							<td style="width: 50%" align="right">
								<label class="shopTop"> Showing <?php echo $liste->rowCount(); ?> results </label>
							</td>			
						</tr>
						<tr>
							<td><br>
								<select class="sortBox">
									<option value="0">--</option>
									<option value="1">Price: Low to High</option>
									<option value="2">Price: High to Low</option>
									<option value="3">Label: Alphabetical</option>
									<option value="4">Rating: Decreasing</option>
									<option value="4">Rating: Increasing</option>
								</select>
							</td>
						</tr>
					</table>
					<table align="center" style="padding-bottom: 60px" cellspacing="20px">
						<tr>
						<?php 
							$current = 0;
							$all = $liste->rowCount();
							foreach($liste as $row){
								$current++;     
								if($current != 3){
							?>
								<td class="productCase" onclick="location.href='item.php?ref=<?php echo $row['ref']; ?>';">
									<table cellspacing="12">
										<tr>
											<td>
												<input type="hidden" value="<?php echo $row['ref']; ?>" name="refProd">
												<img src="../<?php echo $row['images']?>/0.png" class="productImage">
											</td>										
										</tr>
										<tr>
											<td>
												<label class="productLabel"><?php echo $row['label'];?></label>
											</td>
										</tr>
										<tr>
											<td>
												<?php 
													for($i = 0; $i < $row['noteMoy']; $i++){
													?>
														<img src="../images/starFull.png" class="star">
													<?php	
													}	
													for($i = $row['noteMoy']; $i < 5; $i++){
													?>
														<img src="../images/starEmpty.png" class="star">
													<?php
													}
												?>
											</td>
										</tr>
										<tr>
											<td>
												<label class="produitPrix"><?php echo $row['prix'];?> TND</label>
											</td>
										</tr>
									</table>
								</td>
							<?php
								}else{
									?>
								<td class="productCase" onclick="location.href='item.php?ref=<?php echo $row['ref']; ?>';">
									<table cellspacing="12">
										<tr>
											<td>
												<input type="hidden" value="<?php echo $row['ref']; ?>" name="refProd">
												<img src="../<?php echo $row['images']?>/0.png" class="productImage">
											</td>										
										</tr>
										<tr>
											<td>
												<label class="productLabel"><?php echo $row['label'];?></label>
											</td>
										</tr>
										<tr>
											<td>
												<?php 
													for($i = 0; $i < $row['noteMoy']; $i++){
													?>
														<img src="../images/starFull.png" class="star">
													<?php	
													}	
													for($i = $row['noteMoy']; $i < 5; $i++){
													?>
														<img src="../images/starEmpty.png" class="star">
													<?php
													}
												?>
											</td>
										</tr>
										<tr>
											<td>
												<label class="produitPrix"><?php echo $row['prix'];?> TND</label>
											</td>
										</tr>
									</table>
								</td>
							<?php
									$current = 0;
									echo "</tr>";
								}	
								$all--;
							}
							if($all != 0){
								echo "</tr>";
							}
						?>
					</table>
				</td>
			</tr>
		</table>
		<div class="prdBottomImg">
		</div>
		<div class="preFooter">
		</div>
		<div class="footer">
		</div>
	</body>
</html>