
<?php 
session_start();
if (isset($_POST["id"]))
{
$_SESSION['id']=strip_tags($_POST["id"]);
}
else
{
	$_SESSION['id']=2;
}
date_default_timezone_set('UTC');
	function  findEmploi($tab,$tab2)
 {
	
	$inter1=split(' ',$tab);
	 $inter2=split(' ',$tab2);
	 $timezone=new DateTimeZone('UTC');
	$tab= new DateTime($inter1[0],$timezone);
	$tab2=new DateTime($inter2[0],$timezone);
	 $result=$tab2->diff($tab,true);
	 $result=$result->format("%a");
		$entier=intval($result,10);
	$tb=array($entier=>intval($inter2[1],10));
	 return $tb;
}
?>
<?php
			 $information=array();
			$repFinal=array();
			$tabFinal=array();
			$tabInfo=array();
			if (isset($_POST['debut'])&& isset($_SESSION["id"]))
	{			
	
		$element1= strip_tags($_POST['debut']);

	$element1=$element1/1000;
	$actu=date('Y-m-d',$element1);
	 $nextWeek=date('Y-m-d',($element1 +(7*24*3600)));

				try
				{
				$objet=new PDO("pgsql:host=tuxa.sme.utc;dbname=dbnf17p072",'nf17p072','AGQQwk0y');
				}
				catch (Exception $e)
				{
					die('Erreur:'.$e->getMessage());
				}

				$req="select C.nom as name,R.ID,R.date,V.nom,V.prenom from vVeterinaire V , RendezVous R,Client C,Animal A
						where   V.ID=:id  and R.veterinaireID=:id and R.telProprio=A.telProprio and A.telProprio=C.telephone and R.date between :debut and :fin ";
				
				$rep=array('id'=>$_SESSION['id'],'debut'=>$actu,'fin'=> $nextWeek);
				$reponse=$objet->prepare($req);
				$reponse->execute($rep) or die( print_r($reponse->errorInfo()));
					
				while ($answer=$reponse->fetch())
				{
          $information[0]=$answer["name"]; // nom du client 
          $information[1]=$answer["id"]; // id du rendez vous 

			$name=$answer["nom"]; // nom du vetiniraire;
			$prenom=$answer["prenom"];  // prenom du veterinaire
			$tabInfo["nom"]=$name; //
			$tabInfo["prenom"]=$prenom; //  
		
			$res=findEmploi($actu,$answer['date']);
			 foreach ($res as $key=>$val)
			 {
					
				$tabFinal[$key]=array($val,$information[0],$information[1]); //  tableau des rendez vous  et des clients 
			 }
		}
			$repFinal["info"]=$tabInfo; // tableau du veterinaire 
			$repFinal["date"]=$tabFinal; // tableau des dates .
	echo json_encode ($repFinal);

		$reponse->closeCursor();	
	}
?>  
