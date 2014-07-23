<?php
session_start(); // On démarre la session AVANT toute chose
?>
<!DOCTYPE html>

<html >
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../dossierCSS/calendrier.css" />
    <link rel="stylesheet" href="../dossierJS/tooltipster/css/tooltipster.css" />
 		<link rel="stylesheet" href="../dossierCSS/jquerycalendrier.css"/>
    <title>calendrier</title>
  </head>
  <body>
	  <div id="menu">
		  <h2 class="tooltip" title="slt je suis la">menu </h2>
		  <a href="#">Visualiser emploi du temps</a>
	  </div>
	  <div id="separation"></div>
	  <div id="resultat">
		  <h2 class="tooltip"  title ="slt je suis la">Page d'information</h2>
		  <p>verifier votre login ou le mot de passe</p>
		  <form  method="post" action="phpCalendrier.php" id="formcal">
       <!--<label for="id">ID du veterinaire *:</label><input type="password" name="id" id="id"/><br/></br>-->
<label for="debut">date debut *:</label><input type="date" name="debut" id="debut" class="datepicker" placeholder='yyyy-mm-dd'/><br/></br>
        <input type="Button"class='but' id='valider' value="valider" />
       <input type="reset" class='but' value="annuller" />
       </form>
       <div id="photo">
	 <img class="previous" title="previous week"  src="../imageProjet/previous.gif" alt="precedent" />
	 <img  class="next" title="next week"src="../imageProjet/next.gif" alt="next" />
      </div>

			<table id="tableau" >
				<caption></caption>
				    <thead>
					<tr >
					<th class='g'>Horaire/Jour</th>
					 <th class='g'>Lundi</th>
					 <th class='g'>Mardi</th>
					 <th class='g'>Mercredi</th>
					 <th class='g'>Jeudi </th>
					  <th class='g'>Vendredi</th>
					</tr>
					</thead>
				    <tbody>
					<tr >
						<td >08h:09h</td>						
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
					</tr>
					<tr >
						<td >09h:10h</td>						
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
					</tr>
					<tr>
						<td>10h:11h</td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
					</tr>
					<tr >
						<td >11h:12h</td>						
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
					<tr>
						<td>14h:15h</td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						
					</tr>
					<tr >
						<td >15h:16h</td>						
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>

					</tr>
						<td>16h:17h</td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
					</tr>
					<tr>
						<td>17h:18h</td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
						<td><img src="../imageProjet/vrai.jpeg" alt="vrai" /></td>
					</tr>
					</tbody>
			</table>
	</div>
	<script  src="../dossierJS/jquery.js"></script>
    <script  src="../dossierJS/jqueryColor.js"></script>
   <script src="../dossierJS/jquery.tooltipster.min.js"></script>	
    <script src="../dossierJS/overlay.js"></script>
		<script src="../dossierJS/jquerycalendrier.js"></script>
   <script src="../dossierJS/calendrier.js"></script>	

</body>
</html>

