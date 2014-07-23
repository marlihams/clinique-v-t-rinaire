<?php
session_start(); // On d�marre la session AVANT toute chose


?>

<html>
	<head>
		<title>Clinique vététinaire</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link href="styleStat.css" rel="stylesheet" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<div id="banner"><a href="calendrier.php">Retour à l'emploi du temps</a> <a href="veto.php">Retourner à la page du rendez-vous en cours</a></div>
		<?php
					
					include "connect.php";
					$vConn = fConnect();
					
					
					// On récupère les variables s'il y a eus un post
					if (isset($_POST['animalS'])) {
						$_SESSION['animal']=$_POST['animalS'];
					}
					if (isset($_POST['vetoS'])) {
						$_SESSION['veto']=$_POST['vetoS'];
					}
					if (isset($_POST['medocS'])) {
						$_SESSION['medoc']=$_POST['medocS'];
					}
					if (isset($_POST['clientS'])) {
						$_SESSION['client']=$_POST['clientS'];
					}
					
					// On r�cup�re les variables de sessions
					if(isset($_SESSION['medoc']))
					{
						$medoc=$_SESSION['medoc'];
					}
						
					if (isset($_SESSION['veto']))
					{
						$veto=$_SESSION['veto']; 
					}
					if (isset($_SESSION['client']))
					{
						$client=$_SESSION['client']; 
					}
					if (isset($_SESSION['animal']))
					{
						$animal=$_SESSION['animal']; 
					}
					
		?>
					
		
		<div id="medicament"> 
			<div class="entete">
				MEDICAMENT
			</div>
			<form method="post">
				<select id="medocS"  name="medocS">
							
					<?php
						if(isset($_SESSION['medoc']) and $_SESSION['medoc']!='Moyenne totale') {
							echo"<option>$medoc</option>";
							echo "<option>Moyenne totale</option>" ;}
						else echo "<option>Moyenne totale</option>";
						$vSql ="select nommedicament
							from medicament";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo "<option>$vResult[nommedicament]</option>";
						}
					?>
				</select>
				<button type="submit" class="action">OK</button>
			</form>
			<div id="MR1">
				<div class="cercle"><div class="result">
				<?php
						if(isset($_SESSION['medoc']) and $_SESSION['medoc']!='Moyenne totale') 
						$vSql ="select sum(qteprescrite) as total from prescription where nommedicament='$medoc';";
						else $vSql ="select sum(qteprescrite) as total from prescription;";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo "$vResult[total]";
						}
				?>
				</div>
				</div>
				<div class="labelR">Nombre de prescriptions d'un médicament</div>
			</div>
			<div id="MR2">
				<div class="cercle"><div class="result">
				<?php
						if(isset($_SESSION['medoc']) and $_SESSION['medoc']!='Moyenne totale') 
						$vSql ="select avg(somme) as total
						from (
							select sum(qteprescrite) as somme , o.veterinaireid
							from prescription p, ordonnance o
							where p.ordonnanceid=o.ordonnanceid and p.nommedicament='$medoc'
							group by o.veterinaireid, o.ordonnanceid
							) as ressom;";
						else $vQsl="select avg(somme) as total
						from (
							select sum(qteprescrite) as somme , o.veterinaireid
							from prescription p, ordonnance o
							where p.ordonnanceid=o.ordonnanceid
							group by o.veterinaireid, o.ordonnanceid
							) as ressom;";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo substr("$vResult[total]",0,1) ;
						}
				?></div>
				</div>
				<div class="labelL">Moyenne de médicaments prescrits par vétérinaire <br/> par ordonnance</div>
			</div>
			<div id="MR3">
				<div class="cercle"><div class="result">
				<?php
						if(isset($_SESSION['medoc']) and $_SESSION['medoc']!='Moyenne totale') 
						$vSql ="select avg( age(a.datenaissance) ) as moyen
						from prescription p, ordonnance o, animal a 
						where p.ordonnanceid=o.ordonnanceid and o.telproprio=a.telproprio and o.nomanimal=a.nom and p.nommedicament='$medoc';";
						else $vSql="select avg( age(a.datenaissance) ) as moyen
						from prescription p, ordonnance o, animal a 
						where p.ordonnanceid=o.ordonnanceid and o.telproprio=a.telproprio and o.nomanimal=a.nom;";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo substr("$vResult[moyen]",0,1);
						}
				?></div>
				</div>
				<div class="labelR">Age moyen des animaux soignés avec un médicament</div>
			</div>
		</div>
		<div id="veterinaire">
			<div class="entete">
				VÉTÉRINAIRE
			</div>
			<form method="post">
				<select id="vetoS"  name="vetoS">
					<?php
						if(isset($_SESSION['veto']) and $_SESSION['veto']!='Moyenne totale') {
							echo"<option>$veto</option>";
							echo "<option>Moyenne totale</option>" ;}
						else echo "<option>Moyenne totale</option>";
						$vSql ="select id, nom, prenom
							from vveterinaire";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo "<option>$vResult[id] $vResult[nom] $vResult[prenom]</option>";
						}
					?>
				</select>
				<button type="submit" class="action">OK</button>
			</form>
			<div id="VR1">
				<div class="cercle"><div class="result">
					<?php
						if(isset($_SESSION['veto']) and $_SESSION['veto']!='Moyenne totale') {
						$idVetoS=substr($_SESSION['veto'],0,2);
						$vSql ="select avg(q) as qt
						from (
							select count(extract(week from r.date)) as q , extract(week from r.date), r.veterinaireid as v 
							from rendezvous r  
							group by extract(week from r.date),  r.veterinaireid ) as test
						where v='$idVetoS';";}
						else $vSql ="select avg(q) as qt
						from (
							select count(extract(week from r.date)) as q , extract(week from r.date)as v 
							from rendezvous r  
							group by extract(week from r.date) ) as test;";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo substr("$vResult[qt]",0,3);
						}
					?>
				</div>
				</div>
				<div class="labelR">Moyenne des rendez-vous par semaine</div>
			</div>
			<div id="VR2">
				<div class="cercle"><div class="result">
				<?php
						if(isset($_SESSION['veto']) and $_SESSION['veto']!='Moyenne totale') {
						$idVetoS=substr($_SESSION['veto'],0,2);
						$vSql ="select avg(som) as qt
						from (
							select sum(f.prix) as som, r.veterinaireid as v
							from facture f, rendezvous r
							where f.rdvid=r.id
							group by veterinaireid
						) as test
						where v='$idVetoS';";}
						else $vSql ="select avg(som) as qt
						from (
							select sum(f.prix) as som, r.veterinaireid
							from facture f, rendezvous r
							where f.rdvid=r.id
							group by veterinaireid
						) as test;";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						if ("$vResult[qt]"!='') echo substr("$vResult[qt]",0,3);
						else echo"0";
						echo"€";
						}
					?></div>
				</div>
				<div class="labelL">Moyenne CA par rendez-vous</div>
			</div>
		</div>
		<div id="global"> 
			<div class="entete">
				GLOBAL
			</div>
			
			<div id="rdvClient">
				<form method="post">
					<select id="clientS"  name="clientS">
							<?php
								if(isset($_SESSION['client']) and $_SESSION['client']!='Moyenne totale'){
									echo"<option>$client</option>";
									echo "<option>Moyenne totale</option>" ;}
								else echo "<option>Moyenne totale</option>";
								$vSql ="select nom, prenom, telephone
									from client";
								$vQuery=pg_query($vConn, $vSql);
								while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
								echo "<option>$vResult[telephone] $vResult[nom] $vResult[prenom]</option>";
								}
							?>
					</select>
					<button type="submit" class="action">OK</button>
				</form>
				<div id="CR">
					<div class="cercle"><div class="result">
					<?php
						if(isset($_SESSION['client']) and $_SESSION['client']!='Moyenne totale') {
						$tel=substr($_SESSION['client'],0,10); 
						$vSql ="select count(r.*) as rdv 
						from animal a, rendezvous r 
						where a.telproprio=r.telproprio and a.nom=r.nomanimal and a.telproprio='$tel';";}
						else $vSql ="select avg(rdv) as rdv
						from (
							select a.telproprio, count(r.*) as rdv 
							from animal a, rendezvous r 
							where a.telproprio=r.telproprio and a.nom=r.nomanimal 
							group by a.telproprio) as res;";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo substr("$vResult[rdv]",0,3);
						}
					?></div></div>
				</div>
				<div class="labelR">Moyenne des rendez-vous par client</div>
			
			</div>
			<div id="rdvAni">
				<form method="post">
					<select id="animalS"  name="animalS">
							<?php
								if(isset($_SESSION['animal']) and $_SESSION['animal']!='Moyenne totale'){
									echo"<option>$animal</option>";
									echo "<option>Moyenne totale</option>" ;}
								else echo "<option>Moyenne totale</option>";
								$vSql ="select nom, telproprio
									from animal";
								$vQuery=pg_query($vConn, $vSql);
								while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
								echo "<option>$vResult[telproprio] $vResult[nom]</option>";
								}
							?>
					</select>
					<button type="submit" class="action">OK</button>
				</form>
				<div id="AR">
					<div class="cercle"><div class="result">
					<?php
						if(isset($_SESSION['animal']) and $_SESSION['animal']!='Moyenne totale') {
						$tel=substr($_SESSION['animal'],0,10); 
						$nom=substr($_SESSION['animal'],11,20); 
						$vSql ="select count(r.*) as rdv 
						from animal a, rendezvous r 
						where a.telproprio=r.telproprio and a.nom=r.nomanimal and a.nom='$nom' and a.telproprio='$tel';";}
						else $vSql ="select avg(rdv) as rdv
						from (
							select a.nom,a.telproprio, count(r.*) as rdv 
							from animal a, rendezvous r 
							where a.telproprio=r.telproprio and a.nom=r.nomanimal 
							group by a.nom, a.telproprio) as res;";
						$vQuery=pg_query($vConn, $vSql);
						while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo substr("$vResult[rdv]",0,3);
						}
					?></div></div>
				</div>
				<div class="labelL">Moyenne des rendez-vous par animal</div>
			</div>
		</div>
	
	
	
	</body>
</html>
