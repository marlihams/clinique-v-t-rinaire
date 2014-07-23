<?php
session_start(); // On démarre la session AVANT toute chose

?>

<html>
	<head>
		<title>Clinique vététinaire</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="../dossierJS/tooltipster/css/tooltipster.css" />
 		<link rel="stylesheet" href="../dossierCSS/jquerycalendrier.css"/>
		<link  rel="stylesheet"  href="../dossierCSS/client.css" />
		<script type="text/javascript">
			<!--
			function open_ajout()
			{
				window.open('ajoutAnimal.php','ajoutAnimal','menubar=no, scrollbars=no, top=100, left=100, width=500, height=400');
			}
			-->
		</script>
		<script type="text/javascript">
			<!--
			function open_suppr()
			{
				window.open('supprAnimal.php','supprAnimal','menubar=no, scrollbars=no, top=100, left=100, width=500, height=300');
			}
			-->
		</script>
		<script type="text/javascript">
			<!--
			function open_produits()
			{
				window.open('Produits_dispos.php','ConsultProduits','menubar=no, scrollbars=yes, top=100, left=100, width=500, height=300');
			}
			-->
		</script>

	</head>


	<body>
	<div id="infos">
		<div id="IDAnimal">
			<div class="entete">
				Identité animal
			</div>
			

<!-- Informations animal + liste déroulante -->
			<div id="animalClient">
				<?php
					
					include "connect.php";
					$vConn = fConnect();
									
					if(isset($_SESSION['tel']))
					{
						$telP=$_SESSION['tel'];
					}
						
					if ($_SESSION['animal']!='')
					{
						$a=$_SESSION['animal']; 
					}
					
					$sql="SELECT nom FROM animal WHERE telproprio='$telP'";
					$vQuery=pg_query($vConn, $sql);	
					
					echo "<form action='' method='POST'> 
						<table><tr><td>Choisissez votre animal</td>
						<td><select name='animal'>";					
							while($result = pg_fetch_array($vQuery, null, PGSQL_ASSOC)){
								echo "<option>$result[nom]</option>";
								$a="$result[nom]";
							}
						echo"</select></td><td>					
						<input name='OK' type='submit' value='Ok'></td></tr>
						</table>
					</form>"; 
					if ($_SESSION['animal']==''){
						$_SESSION['animal']=$a;
					}
					if (isset($_POST['animal'])) {
						$_SESSION['animal']=$_POST['animal'];
						$a=$_SESSION['animal'];
					}

					if ($_SESSION['animal']!=''){
						$a=$_SESSION['animal']; 
					}

					$vSql ="SELECT nom, espece, poids, age(dateNaissance) as age, sexe 
									FROM Animal 
									WHERE telProprio='$telP' AND nom='$a';";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)){
						echo "<table>";
						echo "<tr><td>Nom :$vResult[nom]</td></tr>";
						echo "<tr><td>Espece :$vResult[espece]</td></tr>";
						echo "<tr><td>Poids :$vResult[poids]kg</td></tr>";
						echo "<tr><td>Age :$vResult[age]</td></tr>";
						echo "<tr><td>Sexe :$vResult[sexe]</td></tr>";
						echo "</table>";
					}
				?>
			</div>
			
		<!-- Photo animal -->
		<?php 
			include("SelectionPhotoAnimal.php");
		?>
		<input type="button" value="Ajouter un animal" onclick="javascript:open_ajout();"> <br>
		<input type="button" value="Consulter produits disponibles" onclick="javascript:open_suppr();"> 

		</div>

<!-- Historique animal -->
		<div id="HistoriqueAnimal">
			<div class="entete">
			Historique Animal
			</div>
			<table>
			<tr border="1"><th>Date</th><th>Prestation</th><th>Vétérinaire</th></tr>
				<?php
					$vSql= "SELECT R.date AS date, RP.intitule AS intitule, V.prenom||' '||V.nom as veto
						FROM rendezvous R, rendezvous_prestation RP, vveterinaire V
						WHERE R.id=RP.rendezvous AND R.veterinaireID=V.id AND R.nomanimal='$a' AND R.telproprio='0695781412' AND R.date<now()
						ORDER BY date ASC;";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo "
						<tr><td>$vResult[date]</td>
						<td>$vResult[intitule]</td>
						<td>$vResult[veto]</td></tr>";
					}
				?>
			</table>
		</div>

<!-- Rendez vous futurs -->
		<div id="A_Venir">
			<div class="entete"> 
			A venir
			</div>
			<table>
			<tr><th>Date</th><th>Prestation</th></tr>
			<?php
					$vSql ="SELECT R.date AS date, RP.intitule AS intitule, V.prenom||' '||V.nom as veto
						FROM rendezvous R, rendezvous_prestation RP, vveterinaire V
						WHERE R.id=RP.rendezvous AND R.veterinaireID=V.id AND R.nomanimal='$a' AND R.telproprio='$telP' AND R.date>now()
						ORDER BY date;";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo "<tr><td>$vResult[date]</td>";
						echo"<td>$vResult[intitule]</td></tr>";
					}
				?>

			</table>
		</div>
	</div>


<!-- PARTIE DE CONSULTATION DES PRODUITS DISPONIBLES A LA CLINIQUE -->

	<div id="rdv">
		<div class="entete"> 
			Consultation Produits
		</div>
		<div id="corpsProduits">
			<input type="button" value="Consulter produits disponibles" onclick="javascript:open_produits();"> 
		</div>
	



<!-- Formulaire de prise d'un nouveau rendez vous -->

<?php include("RDV.php"); ?>
	
<?php
	if (isset($_SESSION['resultat'])) 
{
		$a=$_SESSION['resultat'];
		if ($a==1)
		{
?>
		<script> resultReservation() ? alert(" appointement success"): alert("appointement fail"); </script>
<?php
		}
}
?>


<!--PARTIE CALENDRIER -->

	<?php include("calendrierClient.php"); ?>


	

	<script  src="../dossierJS/jquery.js"></script>
	<script  src="../dossierJS/jqueryColor.js"></script>
	<script src="../dossierJS/jquery.tooltipster.min.js"></script>	
	<script src="../dossierJS/overlay.js"></script>
	<script src="../dossierJS/jquerycalendrier.js"></script>
	<script src="../dossierJS/client.js"></script>	
</body>
</html>
