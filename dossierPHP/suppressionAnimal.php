<?php
	session_start(); 
	include "connect.php";
	$vConn = fConnect();
	$telP=$_SESSION['tel'];
  	$name= $_SESSION['animal'];

	$vSql = "DELETE FROM animal WHERE telproprio='$telP' AND nom='$name'"; 
	$vQuery=pg_query($vConn, $vSql) or die("Requete  incomprise");


?>

<script language=JavaScript>
	window.opener.location.reload();
	self.close();
</script>
