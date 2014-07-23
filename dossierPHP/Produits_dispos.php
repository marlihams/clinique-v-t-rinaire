<?php
session_start(); // On démarre la session AVANT toute chose

?>
<html>
	<head>
		<title>Clinique vététinaire</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="../dossierCSS/client.css" />
	</head>

	<body>
		<div id="produits">
			<div class="entete"> 
				Consultation Produits
			</div>

		<div>
			<table border="1">
				<tr><th>Produit</th><th>Quantité</th><th>Prix</th></tr>
				<?php

					include "connect.php";
					$vConn = fConnect();

					$vSql ="Select nomproduit, quantitedispo, prixproduit FROM produit WHERE quantitedispo>0;";
					$vQuery=pg_query($vConn, $vSql);

				 while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
						echo "<tr>";
						echo "<td>$vResult[nomproduit]</td>";
						echo "<td>$vResult[quantitedispo]</td>";
						echo "<td>$vResult[prixproduit]</td>";
						echo "</tr>";
					}
			?>
			</table>
		</div>
	</body>
</html>
