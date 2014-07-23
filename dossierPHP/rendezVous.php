<?php
	session_start();
	
	if (isset($_SESSION["user"]))
	{
		$login=$_SESSION["user"];
		}
	function insertion($objet,$taille)
	{
		$resultat='<option>';
		 if ($taille==0)
		 $argument='intitule';
		 else
		 $argument='nom';
		
		while($donnee=$objet->fetch())
		{
				 $resultat.''.$donnee[$argument].'</option>'.'<br/><option>';
		}
		return $resultat.'</option>';
	}
		
		
		$len=count($_POST);
		foreach($_POST as $indice=>$value)
		{
				$_POST[$indice]=strip_tags($_POST[$indice]);
		}
		try
		{
		$myObjet=new PDO('pgsql:host=tuxa.sme.utc;dbname=dbnf17p052','nf17p052','JNhvU0Xv');
		}
		catch(Exception $e)
		{
			die('Erreur: '.$e->getMessage());
		}
		
		if ($len==0 || $len==1)
		{
			$reqP= $len==0 ? 'select intitule from Prestation': 'select nom from Employe  where function="veterinaire"';
			 
			 $reponse=$myObjet->prepare($reqP);
			$reponse->execute() or die( print_r($reponse->errorInfo()));
			
				if ($reponse)
				{
					$rep=insertion($reponse,$len);
					echo $rep;
				}
				
		}
		 else
		 {
			 $req_identifiant='select e.EmployeID from Employe e where e.nom=:veterinaire';
			 $rep=array('veterinaire'=>$_POST["veterinaire"]);
			 $reponse=$myObjet->prepare($req_identifiant);
			 $reponse->execute($reqP) or die( print_r($reponse->errorInfo()));
			 $identifiant=$reponse->fetch()["employeID"];
			 $reponse->closeCursor();
				
			 $reqIA='insert into Animal(veterinaireID,nom,race,espec,login,sexe,dateNaissance,nationalID)
				values(:identifiant,:nom,:race,:espece,:login,:sexe,:dateNaissance,:nationalID)';
			 $rep=0;
			 $rep=array('identifiant'=>$identifiant,'nom'=>$_POST["nom"],'race'=>$_POST["race"],'espece'=>$_POST["espece"],
			 'login'=>$login,'sexe'=>$_POST["sexe"],'dateNaissance'=>$_POST["dateNaissance"],'nationalID'=>$_POST["nationalID"]);
				
			 $reponse=$myObjet->prepare($reqIA);
			 $reponse->execute($rep) or die( print_r($reponse->errorInfo()));
			
			$reponse->closeCursor(); // fermer le curseur
				 $rep=0;
				$reqIA='insert into RendezVous(veterinaireID,nomAnimal,loginPro,jour,horaire,intitule)
				values(:veterinaireID,:nomAnimal,:loginPro,:jour,:heur,:prestation)';
				$rep=array('identifiant'=>$identifiant,'nomAnimal'=>$_POST["nomAnimal"],'loginPro'=>$login,
				'jour'=>$_POST["jour"],'heur'=>$_POST["heur"],'prestation'=>$_POST["prestation"]);
				
			 $reponse=$myObjet->prepare($reqIA);
			 $reponse->execute($rep) or die( print_r($reponse->errorInfo()));
			 echo	"ok";
		}
		$reponse->closeCursor();
				
?>

