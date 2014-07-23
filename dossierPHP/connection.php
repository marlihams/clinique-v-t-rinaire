<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();
 
// On s'amuse à créer quelques variables de session dans $_SESSION
$_SESSION['nom'] = '';
$_SESSION['prenom'] = '';
$_SESSION['id'] = '';
$_SESSION['tel'] = '';
$_SESSION['animal']='';
?>


<html>
	<head>
		<title>Clinique vététinaire</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<link href="http://fonts.googleapis.com/css?family=Arizonia" rel="stylesheet" type="text/css">
	</head>
	<body>
		

			<?php
			
					$vHost="tuxa.sme.utc";
					$vDbname="dbnf17p072";
					$vPort="5432";
					$vUser="nf17p072";
					$vPassword="AGQQwk0y";
					$vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");
					
			//initialisation des variables
			$login="";
			$mdp="";
			$tel="";
			$id="";
			$nom="";
			$prenom="";
			$veto=False;
			
			
			//récupération des informations du formulaire
			if(isset($_POST['login'])) {$login = $_POST['login'];}
			if(isset($_POST['mdp'])) {$mdp = $_POST['mdp'];}
			
			$vSql ="SELECT telephone, id 
				FROM utilisateur
				WHERE login = '$login' AND mdp = '$mdp';";
			$vQuery=pg_query($vConn, $vSql);
			while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
				$tel="$vResult[telephone]";
				$id="$vResult[id]";
			}
			if ($tel !=''){
				$vSql ="SELECT nom, prenom 
					FROM client
					WHERE telephone = '$tel';";
				$vQuery=pg_query($vConn, $vSql);
				while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					$nom="$vResult[nom]";
					$prenom="$vResult[prenom]";
				}
				echo"<div id='titre'>Bienvenue $prenom $nom</div>";
				echo "<form id='connection' method='post' action='client.php' >";
				echo "Veuillez cliquer ci-dessous pour acceder à votre espace <br/>";
				echo "<button type='submit' class='action'>Cliquez ici</button>";
				echo "</form>";
				echo $_SESSION['nom'] = $nom;
				echo $_SESSION['prenom'] = $prenom;
				echo $_SESSION['tel'] = $tel;
							
			}else if ($id!=""){
				$vSql ="SELECT nom, prenom 
					FROM vveterinaire
					WHERE id = '$id';";
				$vQuery=pg_query($vConn, $vSql);
				while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
					$nom="$vResult[nom]";
					$prenom="$vResult[prenom]";
				}
				if($nom!="" && $prenom!="") {
					$veto=True;
					echo"<div id='titre'>Bienvenue $prenom $nom</div>";
					echo "<form id='connection' method='post' action='calendrier.php' >";
					echo "Veuillez cliquer ci-dessous pour acceder à votre espace <br/>";
					echo "<button type='submit' class='action'>Cliquez ici</button>";
					echo "</form>";
					echo $_SESSION['nom'] = $nom;
					echo $_SESSION['prenom'] = $prenom;
					echo $_SESSION['id'] = $id;
				}else{
					$vSql ="SELECT nom, prenom 
					FROM employe
					WHERE employeid = '$id';";
					$vQuery=pg_query($vConn, $vSql);
					while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						$nom="$vResult[nom]";
						$prenom="$vResult[prenom]";
					}
					echo"<div id='titre'>Bienvenue $prenom $nom</div>";
					echo "<form id='connection' method='post' action='employe.php' >";
					echo "Veuillez cliquer pour acceder à votre espace <br/>";
					echo "<button type='submit' class='action'>Cliquez ici</button>";
					echo "</form>";
					echo $_SESSION['nom'] = $nom;
					echo $_SESSION['prenom'] = $prenom;
					echo $_SESSION['id'] = $id;
				}
					
			}else{
					
				echo "<form id='connection' method='post' action='indexP.html' >";
				echo "Erreur de connexion <br/>";
				echo "<button type='submit' class='action'>Retourner en arriere </button>";
				echo "</form>";
			}

			?>
