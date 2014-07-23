<?php
	
	// recuperation de l'espece de l'animal 
	$vSql ="SELECT espece FROM animal WHERE telproprio = '$telP' AND nom = '$a'";
	$vQuery=pg_query($vConn, $vSql);
	while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
		$animespece="$vResult[espece]";		
	}

	if(isset($animespece)){
		$photo= $animespece.'.jpg';
		echo"
		<div id='portrait'>
			<img src='../imageProjet/$photo' alt='PHOTO NON TROUVEE'> 
		</div>";
	}
	else{
		echo"
		<div id='portrait'>
			<img src='../imageProjet/inconnu.jpg' alt='PHOTO NON TROUVEE'> 
		</div>";
	}
			
		
?>
