<?php
session_start(); // On démarre la session AVANT toute chose

?>

<HTML>
	<HEAD>   
		<TITLE>
			Suppression Animal
		</TITLE>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
	</HEAD>
	<body>

			<h1>Suppression animal</h1>
			

<!-- Informations animal + liste déroulante -->
			<div id="animalClient2">
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
			
				echo "<form action='suppressionAnimal.php' method='POST'>
							<INPUT type='submit' value='Suppression'>
							</form>";
				?>
		</div>
			
		<div>
			
		</div>


<!--		<script language=JavaScript>
			window.opener.location.reload();
			self.close();
		</script>
-->

	</body>
</HTML>
