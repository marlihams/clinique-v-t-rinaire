
		<div id="nouveau_rdv">
			<div class="entete">
			Prendre un rendez-vous:
			</div>
	
			<?php					
				$vSql1 = "SELECT intitule FROM Prestation"; 
				$vSql2 = "SELECT id, nom, prenom FROM vveterinaire";
				$vQuery1=pg_query($vConn, $vSql1) or die("Requete 1 incomprise");
				$vQuery2=pg_query($vConn, $vSql2) or die("Requete 2 incomprise");				

				echo"
				<form action='NouveauRDV.php' method='POST'> 
					<table>
						<tr>
						<td>Type de prestation 
						<select name='prestation'>"; 
							while ($row=pg_fetch_array($vQuery1, null, PGSQL_ASSOC))
							{ 
								echo"<option>$row[intitule]</option>"; 
							}			
						echo"</select></td>
						</tr>
						
						<tr>
						<td>Quel Vétérinaire souhaitez vous? 
						<select id='vet' name='veterinaire'>"; 
							while ($row=pg_fetch_array($vQuery2, null, PGSQL_ASSOC))
							{ 
								echo"<option>$row[id] . $row[nom] $row[prenom]</option>"; 
							} 
						echo"</select></td>
						</tr> 
						
					 
					<tr>
					<td>Date: <input type='date' name='date' id='datepicker' class='idatepicker' align='left'>";
				
					echo "<select id='heure' name='heure'>";
					for ($h = 8; $h < 18; $h++) {
						if ($h !=12 && $h !=13){ 
						echo '<option value="'.$h.'h">'.$h.'h'.' 00</option>';
						}
					}
					echo "</select></td></tr>;

				</table>
					<input name='Valider' type='submit' value='Réserver'></td></tr>
				</form>"; 
			?>		
		</div> 

</div>
