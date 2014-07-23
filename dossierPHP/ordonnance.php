<?php
session_start(); // On démarre la session AVANT toute chose
?>

<html>
	<head>
		<title>Clinique vététinaire</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>

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
					$ordoID=0;
				
					$int1="";
					$int2="";
					$int3="";
					$int4="";
					$int5="";
				
					$rdvID= $_SESSION['rdvID'];
					
					//recuperation du telephone
					$vSql ="select telproprio as tel from rendezvous where id=$rdvID";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						$telProprio="$vResult[tel]";
						$telP=$telProprio;
					}
					
					
					//Chargement du nom de l'animal
					$vSql2 ="SELECT nomanimal FROM rendezvous WHERE id='$rdvID' ;";
					$vQuery=pg_query($vConn, $vSql2);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						$nomAni="$vResult[nomanimal]";
					}
					
					
					// recuperation de l'ID du vétérinaire 
					$vSql ="select veterinaireid as id from rendezvous where id='$rdvID'";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						$vetoID="$vResult[id]";
					}
					
					
					
					// recuperation de l'ID de l'ordonance
					$vSql ="select ordonnanceid as id from ordonnance";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						if (intval("$vResult[id]")>=$ordoID){
						       $ordoID="$vResult[id]"+1;
						}
					}
					
					
					//recuperation de l'ID facture
					$vSql ="select MAX(factureid) as id from facture";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						$factureID="$vResult[id]"+1;
					}
					
						
					$vSql ="SELECT nom, espece, poids, age(dateNaissance) as age, sexe FROM Animal WHERE telProprio='$telProprio' and nom='$nomAni' ;";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					echo "<table>";
					echo "<tr><td>Nom :$vResult[nom]</td></tr>";
					echo "<tr><td>Espece :$vResult[espece]</td></tr>";
					echo "<tr><td>Poids :$vResult[poids]</td></tr>";
					echo "<tr><td>Age :$vResult[age]</td></tr>";
					echo "<tr><td>Sexe :$vResult[sexe]</td></tr>";
					echo "</table>";
					$a=$nomAni;
					$animespece= "$vResult[espece]";
					}
					
					
					?> 
					
		<!-- Photo animal -->
			
				
					
				
			</div>
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
						where Presta.factureID=Facture.factureID and Facture.telClient='$telProprio';";
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
						where Facture.telClient='$telProprio';";
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
						where r.id='$rdvID' and rp.rendezvous=r.id and rp.intitule=p.intitule";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					echo "<tr><td>$vResult[duree]</td>";
					echo"<td>$vResult[intitule]</td></tr>";
					if($int1=="") $int1="$vResult[intitule]";
					else if ($int2=="") $int2="$vResult[intitule]";
					else if ($int3=="") $int3="$vResult[intitule]";
					else if ($int4=="") $int4="$vResult[intitule]";
					else if ($int5=="") $int5="$vResult[intitule]";
					

					}
				?>
			</table>
		</div>
		<div id="ordonnance">
			<div class="entete">
			Prescription
			</div>
			<div> Vous avez bien complété l'ordonance </div>
			<input type="button" id="voirOrdo" value="La visioner !" onClick=voirOrdo();/>
			
			<?php
			
			//initialisation des variables
			$medoc1="";
			$howmuch1=0;
			$instruction1="";
			$medoc2="";
			$howmuch2=0;
			$instruction2="";
			$medoc3="";
			$howmuch3=0;
			$instruction3="";
			$medoc4="";
			$howmuch4=0;
			$instruction4="";
			$medoc5="";
			$howmuch5=0;
			$instruction5="";
			$instructions="";
			
			
			
			//r√©cup√©ration des informations du formulaire
			if(isset($_POST['medoc1'])) {$medoc1 = $_POST['medoc1'];}
			if(isset($_POST['howmuch1'])) {$howmuch1 = $_POST['howmuch1'];}
			if(isset($_POST['instruction1'])) {$instruction1 = $_POST['instruction1'];}
			if(isset($_POST['medoc2'])) {$medoc2 = $_POST['medoc2'];}
			if(isset($_POST['howmuch2'])) {$howmuch2 = $_POST['howmuch2'];}
			if(isset($_POST['instruction2'])) {$instruction2 = $_POST['instruction2'];}
			if(isset($_POST['medoc3'])) {$medoc3 = $_POST['medoc3'];}
			if(isset($_POST['howmuch3'])) {$howmuch3 = $_POST['howmuch3'];}
			if(isset($_POST['instruction3'])) {$instruction3 = $_POST['instruction3'];}
			if(isset($_POST['medoc4'])) {$medoc4 = $_POST['medoc4'];}
			if(isset($_POST['howmuch4'])) {$howmuch4 = $_POST['howmuch4'];}
			if(isset($_POST['instruction4'])) {$instruction4 = $_POST['instruction4'];}
			if(isset($_POST['medoc5'])) {$medoc5 = $_POST['medoc5'];}
			if(isset($_POST['howmuch5'])) {$howmuch5 = $_POST['howmuch5'];}
			if(isset($_POST['instruction5'])) {$instruction5 = $_POST['instruction5'];}
			if(isset($_POST['instructions'])) {$instructions = $_POST['instructions'];}
			if ($instructions !='Veuillez saisir les instructions pour le client'){
				$vSql ="insert into ordonnance(ordonnanceid, veterinaireid, nomanimal,telproprio, instructions) values($ordoID, $vetoID, '$nomAni', '$telProprio','$instructions');";
				$vQuery=pg_query($vConn, $vSql);
			}else {
				$vSql ="insert into ordonnance(ordonnanceid, veterinaireid, nomanimal,telproprio) values($ordoID, $vetoID, '$nomAni', '$telProprio');";
				$vQuery=pg_query($vConn, $vSql);
			};
				
			
			if( $medoc1!="" && $howmuch1!=0) {
				$vSql3 ="insert into prescription(ordonnanceid, nommedicament, qteprescrite ,instructions) values($ordoID, '$medoc1', $howmuch1, '$instruction1');";
				$vQuery=pg_query($vConn, $vSql3);
			};
			if( $medoc2!="" && $howmuch2!=0) {
				$vSql4 ="insert into prescription(ordonnanceid, nommedicament, qteprescrite ,instructions) values($ordoID, '$medoc2', $howmuch2, '$instruction2');";
				$vQuery=pg_query($vConn, $vSql4);
			};
			if( $medoc3!="" && $howmuch3!=0) {
				$vSql5 ="insert into prescription(ordonnanceid, nommedicament, qteprescrite ,instructions) values($ordoID, '$medoc3', $howmuch3, '$instruction3');";
				$vQuery=pg_query($vConn, $vSql5);
			};
			if( $medoc4!="" && $howmuch4!=0) {
				$vSql6 ="insert into prescription(ordonnanceid, nommedicament, qteprescrite ,instructions) values($ordoID, '$medoc4', $howmuch4, '$instruction4');";
				$vQuery=pg_query($vConn, $vSql6);
			};
			if( $medoc5!="" && $howmuch5!=0) {
				$vSql7 ="insert into prescription(ordonnanceid, nommedicament, qteprescrite ,instructions) values($ordoID, '$medoc5', $howmuch5, '$instruction5');";
				$vQuery=pg_query($vConn, $vSql7);
			};
			
			$vSql ="insert into facture(factureid, dateedition, telclient,rdvid) values($factureID,CURRENT_DATE , '$telProprio', $rdvID);";
			$vQuery=pg_query($vConn, $vSql);
			
			$vSql ="insert into refere(ordonnanceid, factureid) values($ordoID, $factureID);";
			$vQuery=pg_query($vConn, $vSql);
			
			if( $medoc1!="" && $howmuch1!=0) {
				$vSql3 ="insert into venteproduit values('$medoc1',$factureID, $howmuch1);";
				$vQuery=pg_query($vConn, $vSql3);
			};
			if( $medoc2!="" && $howmuch2!=0) {
				$vSql4 ="insert into venteproduit values('$medoc2',$factureID, $howmuch2);";
				$vQuery=pg_query($vConn, $vSql4);
			};
			if( $medoc3!="" && $howmuch3!=0) {
				$vSql5 ="insert into venteproduit values('$medoc3',$factureID, $howmuch3);";
				$vQuery=pg_query($vConn, $vSql5);
			};
			if( $medoc4!="" && $howmuch4!=0) {
				$vSql6 ="insert into venteproduit values('$medoc4',$factureID, $howmuch4);";
				$vQuery=pg_query($vConn, $vSql6);
			};
			if( $medoc5!="" && $howmuch5!=0) {
				$vSql3 ="insert into venteproduit values('$medoc5',$factureID, $howmuch5);";
				$vQuery=pg_query($vConn, $vSql7);
			};
			
			if($int1!=""){
				$vSql ="insert into venteprestation values('$int1',$factureID);";
				$vQuery=pg_query($vConn, $vSql);
			}
			if ($int2!=""){
				$vSql ="insert into venteprestation values('$int2',$factureID);";
				$vQuery=pg_query($vConn, $vSql);
			}
			if ($int3!=""){
				$vSql ="insert into venteprestation values('$int3',$factureID);";
				$vQuery=pg_query($vConn, $vSql);
			}
			if ($int4!=""){
				$vSql ="insert into venteprestation values('$int4',$factureID);";
				$vQuery=pg_query($vConn, $vSql);
			}
			if ($int5!=""){
				$vSql ="insert into venteprestation values('$int5',$factureID);";
				$vQuery=pg_query($vConn, $vSql);
			}
			

			
			echo "<div id='ordocomplete'>";
			echo "<table>";
			echo "<tr><td>Medicament</td><td>Quantite</td><td>Instruction</td></tr>";
			
			$vSql="select nommedicament, qteprescrite, instructions from prescription where ordonnanceid='$ordoID'";
			
			$vQuery=pg_query($vConn, $vSql);
			while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					echo "<tr><td>$vResult[nommedicament]</td>";
					echo"<td>$vResult[qteprescrite]</td>";
					echo"<td>$vResult[instructions]</td></tr>";
					}
					
			echo"</table>";
			echo "</div>";
						
			?>
			
			
		</div>
	</div>
	</body>
</html>


