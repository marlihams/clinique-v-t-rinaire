<HTML>
   <HEAD>   
      <TITLE>
         Ajout Animal
      </TITLE>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">		
		<link href="style.css" rel="stylesheet" type="text/css">

		<script type="text/javascript">
			<!--
			function exit()
				{
					window.opener.location.reload();
					self.close();
				}
			-->
		</script>
   </HEAD>


<?php
	session_start(); 
	include "connect.php";
	$vConn = fConnect();
	$telP=$_SESSION['tel'];
	$name= $_POST['nom'];
	$race=$_POST['race'];
	$poids=$_POST['poids'];
	$sexe=$_POST['sexe'];
	$naissance=$_POST['date'];

  $vSql = "SELECT nomespece FROM race WHERE nomrace='$race'"; 
				
  $vQuery=pg_query($vConn, $vSql) or die("Requete  incomprise");
  $row=pg_fetch_array($vQuery, null, PGSQL_ASSOC);
  $espece= $row["nomespece"];  


if(isset($telP, $naissance, $name, $race, $poids, $espece, $sexe) && is_numeric($poids)){
	
	$vSql = "INSERT INTO animal (telproprio, nom, race, espece, poids, sexe, datenaissance) VALUES ('$telP', '$name', '$race', '$espece', $poids, '$sexe', to_date('$naissance', 'YYYY/MM/DD'))"; 
			
	$vQuery=pg_query($vConn, $vSql) or die("Requete incomprise");
	echo "Récapitulatif:<br>
	Nom".$name."<br>
	Espece:".$espece."
	Poids:".$poids."<br>
	Naissance:".$naissance."<br>";
}
?>
<a href="#null" onclick="javascript:exit();">Retour page client</a>


