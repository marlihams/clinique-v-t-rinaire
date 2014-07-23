<?php
session_start(); // On démarre la session AVANT toute chose

?>
<html>
	<head>
		<title>Clinique vététinaire</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
		
	</head>
	<body>
	<?php
							$vHost="tuxa.sme.utc";
							$vDbname="dbnf17p072";
							$vPort="5432";
							$vUser="nf17p072";
							$vPassword="AGQQwk0y";
							$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");
						?>	
	<div id="infos">
		<div id="IDproduit">
			<div class="entete">
				 Gerer les stocks et ventes
			</div>
			<div id="produit">
			
			<form id="formulaire" method="POST" action="employe.php">
					<select id="produit" class="medocclass" name="produit">
							
						<?php
						
							
							
							$vSql ="select nomProduit AS nom
								from Produit
								ORDER BY nom ";
							
							$vQuery=pg_query($vConn, $vSql);
							while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
								echo "<option>$vResult[nom]</option>";
								$b="$vResult[nom]";
								
							}
					
							echo "</select>
							<label for='qte'>Quantite:</label>
							<input type='number' name='qte' value='0' min='-20' > <br/><br/>
							<input name='OK' type='submit' value='OK'>
							</form>";
							if ($_SESSION['produit']==''){
								$_SESSION['produit']=$b;
							}
							if (isset($_POST['produit'])) {
								$_SESSION['produit']=$_POST['produit'];
								$b=$_SESSION['produit'];
							}
							if ($_SESSION['produit']!=''){
								$b=$_SESSION['produit']; 
							}
							if ($_SESSION['qte']==''){
								$_SESSION['qte']=$c;
							}
							if (isset($_POST['qte'])) {
								$_SESSION['qte']=$_POST['qte'];
								$c=$_SESSION['qte'];
							}
							if ($_SESSION['qte']!=''){
								$c=$_SESSION['qte']; 
							
							}
							
							
												
							$vSql ="UPDATE Produit SET quantiteDispo = quantiteDispo + $c WHERE nomProduit='$b';";
							$vQuery=pg_query($vConn, $vSql);
		
						?>
					
			<?php
					$vSql ="select nomProduit AS nom, prixProduit AS prix, quantiteDispo AS quantite 
						FROM Produit
						ORDER BY nom;";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					echo "<table>";	
					echo "<tr><td>Nom : $vResult[nom]</td>";
					echo "<td>Prix : $vResult[prix]</td>";
					echo "<td>Quantite : $vResult[quantite]</td></tr>";
					echo "</table>";
					}
				?>
				
			</div>
		</div>
		<div id="Sauver">
			<div class="entete">
			Sauvegarder des données comptables
			</div>
			<label for="sauver">Client:</label>
					<select id="sauver" class="medocclass" name="sauver">
						<option></option>
						<?php
							$vSql ="select nom
								from Client";
							$vQuery=pg_query($vConn, $vSql);
							while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
							echo "<option>$vResult[nom]</option>";
							}
						?>
					</select>
					<br>
					<br>
			<?php
					$vSql ="select F.factureID AS facture, C.nom AS nom
						FROM Facture F, Client C
						WHERE F.telClient=C.telephone
						GROUP BY C.nom,facture;";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo "<table>";
						echo "<tr><td>Facture :$vResult[facture]</tr>";
						echo "<tr>Nom :$vResult[nom]</td></tr>";
						echo "</table>";
					}
				?>
			</table>
		</div>
		
		<div id="Editer une facture">
			<div class="entete"> 
			Editer une Facture
			</div>
			<div id="facture">
				<?php
					$vSql ="SELECT factureID AS facture
					FROM Facture
					ORDER BY facture;";
					$vQuery=pg_query($vConn, $vSql);				
					echo "<form action='employe.php' method='POST'>
					<table><tr><td>Choissisez la facture</td>
					<td><select name='facture'>";
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
							echo "<option>$vResult[facture]</option>";
							$y="$vResult[nom]";
						}
					echo"</select></td>
					<td><tr>Choissisez le moyen de paiement</td>
					<td><select name='paiement'>";
					echo "<option>CB</option>";
					echo "<option>cheque</option>";
					echo "<option>espece</option>";
					$mp="espece";
					
					echo"</select></td></tr>
					
					<td><tr><input name='OK' type='submit' value='OK'></td></tr>
					</table>
					</form>";
					
					if ($_SESSION['facture']==''){
								$_SESSION['facture']=$y;
							}
							if (isset($_POST['facture'])) {
								$_SESSION['facture']=$_POST['facture'];
								$y=$_SESSION['facture'];
							}
							if ($_SESSION['facture']!=''){
								$y=$_SESSION['facture']; 
							}
							
					if ($_SESSION['paiement']==''){
								$_SESSION['paiement']=$mp;
							}
							if (isset($_POST['paiement'])) {
								$_SESSION['paiement']=$_POST['paiement'];
								$mp=$_SESSION['paiement'];
							}
							if ($_SESSION['paiement']!=''){
								$mp=$_SESSION['paiement']; 
							}
							
							
					$vSql ="select F.factureID AS fact, F.dateEdition AS date, F.moyenPayement AS moyen, F.prix AS prix, F.telClient AS tel, C.nom AS nom
						FROM Facture F, Client C
						WHERE F.factureID='$y' AND F.telClient=C.telephone;";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo "<table>";
						echo "<tr><td>La facture numéro  $vResult[fact] édité le $vResult[date]</td></tr>";
						echo "<tr><td>concernant le Client Mr/Mme $vResult[nom] (numéro de Tel  $vResult[tel] )</td></tr>";
						echo "<tr><td>a payé $vResult[prix]€ en $vResult[moyen]</td></tr>";
						echo "</table>";
					}
				?>
		</div>
		
		<div id="Consulter les prix">
			<div class="entete">
			Consulter les prix
			</div>
			<div id="produit">
						<?php
							$vSql ="SELECT nomProduit AS nom
								FROM Produit
								ORDER BY nom;";
							$vQuery=pg_query($vConn, $vSql);
							echo "<form action='employe.php' method='POST'>
							<table><tr><td>Choissisez le produit</td>
							<select name='produit2'>";
								while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
									echo "<option>$vResult[nom]</option>";
									$z="$vResult[nom]";
								}
							echo "</select></td><td>
							<input name='OK' type='submit' value='OK'></td></tr>
							</table>
							</form>";
							if ($_SESSION['produit2']==''){
								$_SESSION['produit2']=$z;
							}
							if (isset($_POST['produit2'])) {
								$_SESSION['produit2']=$_POST['produit2'];
								$z=$_SESSION['produit2'];
							}
							if ($_SESSION['produit2']!=''){
								$z=$_SESSION['produit2']; 
							}
							$vSql ="select prixProduit AS prix, nomProduit AS nom
							FROM Produit
							WHERE nomProduit='$z';";
							$vQuery=pg_query($vConn, $vSql);
							while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
								echo "<table>";
								echo "<tr><td>$vResult[nom] : $vResult[prix]</td>";
								echo "</table>";
							}
				?>	
			</div>	
			
		</div>
		</div>
	</div>
	</body>
</html>
