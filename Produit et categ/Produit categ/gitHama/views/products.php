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
			if(isset($_GET['search'])){
		        $search = $_GET['search'];
		    }else{
		        $search = "";
		    }
		    if(isset($_GET['sort'])){
		        $sort = $_GET['sort'];
		    }else{
		        $sort = "";
		    }
		    if(isset($_GET['idCateg'])){
		        $idCateg = $_GET['idCateg'];
		    }else{
		        $idCateg = "";
		    }
		   	$liste = $produit1C->afficherProduitsParam($idCateg, $search, $sort);    
		?>
		<table class="productTable">
			<tr>
				<td class="left" align="center" valign="top">
					<table style="margin-bottom: 120px">
						<tr>
							<td style="padding-bottom: 13px;">
								<label class="prTitle">SEARCH</label>
							</td>
						</tr>
						<tr>
							<td>
								<form class="searchBar" method="POST" action="crud/updateProductList.php">
									<table style="width: 100%; height: 100%;border-collapse: collapse;">
										<tr>
											<td class="searchLeft">
												<input type="search" placeholder="Search products..." class="search" name="search" value="<?php if(isset($_GET['search'])){ echo $_GET['search']; }?>">
											</td>
											<td class="searchRight">
												<?php 
													if(isset($_GET['sort'])){
												?>
												<input type="hidden" name="sort" value="<?php echo $_GET['sort']?>">
												<?php 
													}
												?>
												<?php 
													if(isset($_GET['idCateg'])){
												?>
												<input type="hidden" name="idCateg" value="<?php echo $_GET['idCateg']?>">
												<?php 
													}
												?>
												<input type="submit" class="searchBtn" value="🔍" name="searchButton">
											</td>
										</tr>
									</table>	
								</form>
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
							            <a href="products.php?idCateg=<?php echo $row['id'];?>" class="categorie" <?php $cr=0; if(isset($_GET['idCateg'])){if($row['id'] == $_GET['idCateg']){echo 'id="currCat"'; $cr=1;}} ?>><?php echo $row['nom']; if($cr==1){echo " &nbsp; &nbsp;◀";}?></a>
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
							$listeAvis = $AvisC->afficherAvisSorted();
						 	$count = 0;
							foreach($listeAvis as $rowAvis){
							    $count++;
							    if($count < 7){
							    	$rf = $rowAvis['refProduit'];
							    	$iC = $rowAvis['idClient'];
							    	?>
							    	<table class="oneReview" onclick="location.href='item.php?ref=<?php echo $rf;?>&#r<?php echo $iC?>';">
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
								    				?>
								    					<img src="../<?php echo $p['images']; ?>/0.png" alt="productIcon" class="rvPrdIcon">
								    				<?php
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
								<form method="POST" id="formSort" action="crud/updateProductList.php">
									<?php
										if(isset($_GET['sort'])){
											$s = $_GET['sort'];
										}else{
											$s = 0;
										}
									?>
									<select class="sortBox" name="sort" onchange="document.getElementById('formSort').submit()">
										<option value="0" <?php if($s == 0){echo 'selected="selected"';}?>>--</option>
										<option value="1" <?php if($s == 1){echo 'selected="selected"';}?>>Price: Low to High</option>
										<option value="2" <?php if($s == 2){echo 'selected="selected"';}?>>Price: High to Low</option>
										<option value="3" <?php if($s == 3){echo 'selected="selected"';}?>>Label: Alphabetical</option>
										<option value="4" <?php if($s == 4){echo 'selected="selected"';}?>>Rating: Decreasing</option>
										<option value="5" <?php if($s == 5){echo 'selected="selected"';}?>>Rating: Increasing</option>
									</select>
									<?php 
										if(isset($_GET['idCateg'])){
									?>
									<input type="hidden" name="idCateg" value="<?php echo $_GET['idCateg']?>">
									<?php 
										}
									?>
									<?php 
										if(isset($_GET['search'])){
									?>
									<input type="hidden" name="search" value="<?php echo $_GET['search']?>">
									<?php 
										}
									?>
								</form>
							</td>
						</tr>
					</table>
					<table style="padding-bottom: 60px; margin-left: 50px" cellspacing="20px">
						<tr>
						<?php 
							include("../entities/Event.php");
							include("../core/EventC.php");
							$eventC = new EventC();
							$date = date("Y/m/d H:i:s");
							$eventActuel = $eventC->recupererEventByDate($date);
							include("../core/RemiseC.php");
							include("../entities/Remise.php");
							$remiseC = new RemiseC();
							$current = 0;
							$all = $liste->rowCount();
							foreach($liste as $row){
								$onSale = false; 
								$tx = 0;
								if($eventActuel->rowCount() != 0){
									$eventActuel = $eventC->recupererEventByDate($date);
									foreach($eventActuel as $rowEvent){
										$remise = $remiseC->recupererRemise($row['ref'], $rowEvent['id']);
										if($remise->rowCount() != 0){
											$onSale = true; 
											foreach($remise as $rowRemise){
												$tx = $rowRemise['taux'];
											}	
										}
									}
								}
								$current++;  
								if($current != 3){
							?>
								<td class="productCase" onclick="location.href='item.php?ref=<?php echo $row['ref']; ?>';">
									<table cellspacing="12">
										<tr>
											<td>
												<input type="hidden" value="<?php echo $row['ref']; ?>" name="refProd">
												<div class="productImage" style="background-image: url('../<?php echo $row['images']?>/0.png')">
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
												<?php
													if($onSale){
												?>
												<label class="produitPrixSolde"><?php echo $row['prix']; ?> TND </label>
												<label class="produitPrix"><?php echo $row['prix']*$tx/100;?> TND</label>
												<?php
													}else{
												?>
												<label class="produitPrix"><?php echo $row['prix'];?> TND</label>
												<?php
													}
												?>
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
												<div class="productImage" style="background-image: url('../<?php echo $row['images']?>/0.png')">
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
												<?php
													if($onSale){
												?>
												<label class="produitPrixSolde"><?php echo $row['prix']; ?> TND </label>
												<label class="produitPrix"><?php echo $row['prix']*$tx/100;?> TND</label>
												<?php
													}else{
												?>
												<label class="produitPrix"><?php echo $row['prix'];?> TND</label>
												<?php
													}
												?>
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