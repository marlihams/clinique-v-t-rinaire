<?php
session_start(); // On démarre la session AVANT toute chose
?>

<html>
	<head>
		<title>Clinique vététinaire</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
				
				function bouton2(){
					$("#button2").hide();
					$("#divmedoc2").show();
				}
				
				function bouton3(){
					$("#button3").hide();
					$("#divmedoc3").show();
				}
				
				function bouton4(){
					$("#button4").hide();
					$("#divmedoc4").show();
				}
				function bouton5(){
					$("#button5").hide()
					$("#divmedoc5").show();
				}
				
				$(document).ready(function(){
						
						$("#divmedoc2").hide();
						$("#divmedoc3").hide();
						$("#divmedoc4").hide();
						$("#divmedoc5").hide();
						$("#button2").show();
				});
						
		</script>
	</head>
	<body>
	<div id="banner"><a href="calendrier.php">Retour à l'emploi du temps</a> <a href="stat.php">Consulter la page de statistiques</a></div>
	<div id="infos">
		<div id="IDAnimal">
			<div class="entete">
				Identité animal
			</div>
			
			<div id="animal">
			<?php
					include "connect.php";
					$vConn = fConnect();
					
					$_SESSION['rdvID']=$_GET['numero'];
					$rdvID=$_SESSION['rdvID'];
					
					$vSql ="select telproprio as tel from rendezvous where id=$rdvID";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						$telP="$vResult[tel]";
					}
					
					$vSql ="SELECT a.nom as nom, a.poids as poids, a.espece as espece, age(a.dateNaissance) as age, a.sexe as sexe FROM Animal a, rendezvous r WHERE r.id='$rdvID' and r.telproprio=a.telproprio and r.nomanimal=a.nom;";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					echo "<table>";
					echo "<tr><td>Nom :$vResult[nom]</td></tr>";
					$a="$vResult[nom]";
					echo "<tr><td>Espece :$vResult[espece]</td></tr>";
					echo "<tr><td>Poids :$vResult[poids]</td></tr>";
					echo "<tr><td>Age :$vResult[age]</td></tr>";
					echo "<tr><td>Sexe :$vResult[sexe]</td></tr>";
					echo "</table>";
					}
					$id=$_SESSION['id'];
				?>
			</div>
			
			<!-- Photo animal -->
			<?php include("SelectionPhotoAnimal.php");?>
			
		</div>
		
		
		<div id="HistoriqueAnimal">
			<div class="entete">
			Historique Animal
			</div>
			<table>
			<tr><td>Date</td><td>Prestation</td></tr>
			<?php
			
					$vSql ="select  Facture.dateEdition as date,Presta.intitule as intitule
						from VentePrestation Presta,  Facture 
						where Presta.factureID=Facture.factureID and Facture.telClient='$telP';";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					echo "<tr><td>$vResult[date]</td>";
					echo "<td>$vResult[intitule]</td></tr>";}
				?>
			</table>
		</div>
		<div id="HistoriqueClient">
			<div class="entete"> 
			Historique Client
			</div>
			<table>
			<tr><td>Date</td><td>Prix</td><td>Statut</td></tr>
			<?php
					$vSql ="select  dateEdition as date, prix, CASE 	
							WHEN datepayement is not null THEN 'Réglé'
						ELSE 'En attente de paiement' 
						END statut
						from Facture 
						where Facture.telClient='$telP';";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					echo "<tr><td>$vResult[date]</td>";
					echo"<td>$vResult[prix]</td>";
					echo"<td>$vResult[statut]</td></tr>";
					}
				?>
			</table>
		</div>
	</div>
	<div id="rdv">
		<div id="odj">
			<div class="entete">
			Ordre du jour
			</div>
			<table>
			<tr><td>Durée</td><td>Traitement</td></tr>
			<?php
					$vSql ="select rp.intitule as intitule, p.duree as duree
						from rendezvous_prestation rp, prestation p, rendezvous r
						where rp.rendezvous=r.id and r.id='$rdvID' and rp.intitule=p.intitule";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					echo "<tr><td>$vResult[duree]</td>";
					echo"<td>$vResult[intitule]</td></tr>";
					}
				?>
			</table>
		</div>
		<div id="ordonnance">
			<div class="entete">
			Prescription
			</div>
			<form id="formulaire" method="post" action="ordonnance.php" onsubmit="return verifier()">
				<br/>
				<br/>
				<div id="divmedoc1">
				<label for="medoc1">Médicament:</label>
					<select id="medoc1" class="medocclass" name="medoc1">
						<option></option>
						<?php
							$vSql ="select nommedicament
								from medicament";
							$vQuery=pg_query($vConn, $vSql);
							while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
							echo "<option>$vResult[nommedicament]</option>";
							}
						?>
					</select>
				<label for="howmuch1">Quantité:</label>
					<input type="number" name="howmuch1" value="1" min="0" > <br/><br/>
				<label for="instruction1">Instructions spécifique:</label>
					<input type="text" name="instruction1" value="" > <br/><br/>
				<input type="button" id="button2" value="Ajouter un médicament" onClick=bouton2();>
				</div>
				
				
				<div id="divmedoc2">	
				<label for="medoc2">Médicament:</label>
					<select id="medoc2" class="medocclass" name="medoc2">
						<option></option>
						<?php
							$vSql ="select nommedicament
								from medicament";
							$vQuery=pg_query($vConn, $vSql);
							while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
							echo "<option>$vResult[nommedicament]</option>";
							}
						?>
					</select>
				<label for="howmuch2">Quantité:</label>
					<input type="number" name="howmuch2" value="1" min="0" > <br/> <br/>
				<label for="instruction2">Instructions spécifique:</label>
					<input type="text" name="instruction2" value="" > <br/><br/>
				<input type="button" id="button3" value="Ajouter un médicament" onClick=bouton3();>
				</div >
				
				
				<div id="divmedoc3">
				<label for="medoc3">Médicament:</label>
					<select id="medoc3" class="medocclass" name="medoc3">
						<option></option>
						<?php
							$vSql ="select nommedicament
								from medicament";
							$vQuery=pg_query($vConn, $vSql);
							while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
							echo "<option>$vResult[nommedicament]</option>";
							}
						?>
					</select>
				<label for="howmuch3">Quantité:</label>
					<input type="number" name="howmuch3" value="1" min="0" > <br/> <br/>
				<label for="instruction3">Instructions spécifique:</label>
					<input type="text" name="instruction3" value="" > <br/><br/>
				<input type="button" id="button4" value="Ajouter un médicament" onClick=bouton4();>
				</div>
					
				
				<div id="divmedoc4">	
				<label for="medoc4">Médicament:</label>
					<select id="medoc4" class="medocclass" name="medoc4">
						<option></option>
						<?php
							$vSql ="select nommedicament
								from medicament";
							$vQuery=pg_query($vConn, $vSql);
							while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
							echo "<option>$vResult[nommedicament]</option>";
							}
						?>
					</select>
				<label for="howmuch4">Quantité:</label>
					<input type="number" name="howmuch4" value="1" min="0" > <br/> <br/>
				<label for="instruction4">Instructions spécifique:</label>
					<input type="text" name="instruction4" value="" > <br/><br/>
				<input type="button" id="button5" value="Ajouter un médicament" onClick=bouton5();>
				</div>
				
				<div id="divmedoc5">	
				<label for="medoc5">Médicament:</label>
					<select id="medoc5" class="medocclass" name="medoc5">
						<option></option>
						<?php
							$vSql ="select nommedicament
								from medicament";
							$vQuery=pg_query($vConn, $vSql);
							while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
							echo "<option>$vResult[nommedicament]</option>";
							}
						?>
					</select>
				<label for="howmuch5">Quantité:</label>
					<input type="number" name="howmuch5" value="1" min="0" > <br/> <br/>
				<label for="instruction5">Instructions spécifique:</label>
					<input type="text" name="instruction5" value="" > <br/><br/>
				</div>
				<br/> <br/>	
			
				<TEXTAREA name="instructions" id="instructions" rows=4 cols=40>Veuillez saisir les instructions pour le client</TEXTAREA>
				
				<br/> <br/>
				
				
				<button type="reset" class="right" >Annuler</button>
				<button type="submit" class="action">Envoyer</button>
			</form> 
		</div>
	</div>
	</body>
</html>
