<HTML>
   <HEAD>   
      <TITLE>
         Ajout Animal
      </TITLE>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<link rel="stylesheet" href="../dossierCSS/jquerycalendrier.css"/>
			<link  rel="stylesheet"  href="../dossierCSS/client.css" />			
			<link href="style.css" rel="stylesheet" type="text/css">
   </HEAD>
	<body>
	   <?php
        include"connect.php";
				$vConn=fConnect();

				$vSql1 = "SELECT nomespece as nomespece  FROM Espece"; 
				
				$vQuery1=pg_query($vConn, $vSql1) or die("Requete 1 incomprise");
		        
				echo "
        <form method='POST' ACTION='InsertionAnimal.php'>
				<h1> Ajouter un animal </h1>
				<table>
					<tr><td>Nom: </td><td><input type='text' name='nom' required > </td></tr>";
					
					$vSql2 = "SELECT nomrace FROM race";
					$vQuery2=pg_query($vConn, $vSql2) or die("Requete 2 incomprise");
					
					echo"<tr><td> Race: </td><td>
					  <select name='race'>"; 
						while ($row=pg_fetch_array($vQuery2, null, PGSQL_ASSOC))
						{ 
							echo"<option> $row[nomrace]</option>";
						}
					echo"</select></td></tr>";						
					
					echo "
					  <tr><td>Sexe:</td><td>
						<select id='sexe' name='sexe'>";
						echo '<option value=M>M</option>';
						echo '<option value=F>F</option>';
					echo "</select></td></tr>
					
          <tr><td>Poids:</td><td><input type='number' name='poids' required></td></tr>

					<tr><td>Date: </td><td><input type='date' name='date' id='datepicker' class='idatepicker' align='left' required></td></tr>
					
					<tr><td></td>
          <td><input type='submit' name='Valider' value='Ajouter'><td></tr>
				</table>
      </form>";
		?>	

		<script  src="../dossierJS/jquery.js"></script>
		<script  src="../dossierJS/jqueryColor.js"></script>
		<script src="../dossierJS/jquery.tooltipster.min.js"></script>	
		<script src="../dossierJS/overlay.js"></script>
		<script src="../dossierJS/jquerycalendrier.js"></script>
		<script src="../dossierJS/client.js"></script>
	
	</BODY>
</HTML>
