		echo '<strong>je suis la</strong>';

<?php
	session_start();
		$len=count($_POST);
		
		/*for ($i=0;i<$len;$i++)
		{
				$_POST[$i]=strip_tags($_POST[$i]);
		}*/
		try
		{
		$myObjet=new PDO('pgsql:host=tuxa.sme.utc;dbname=dbnf17p052','nf17p052','JNhvU0Xv');
		}
		catch(Exception $e)
		{
			die('Erreur: '.$e->getMessage());
		}
		$_SESSION["user"]=strip_tags($_POST["login"]);
		if ($len==2)
		{
			
			$req='select login, numero from Client where  login= :log and numero=:num';
			$rep=array('log'=>$_POST["login"],'num'=>$_POST["numero"]);
		}
		else 
		{
			$req='insert into Client (login,nom,prenom,motDePasse,numero,adresseMail)
					values
					(:login,:nom,:prenom,:motDePasse,:numero,:adresseMail)';
				$rep=array('login'=>$_POST["login"],'nom'=>$_POST["nom"],'prenom'=>$_POST["prenom"],'motDePasse'=>$_POST["pass"],
								'numero'=>$_POST["numero"],'adresseMail'=>$_POST["mail"]);
			
		}
		 $reponse=$myObjet->prepare($req);
		 $reponse->execute($rep) or die( print_r($reponse->errorInfo()));
		 if ($reponse)
			echo 'ok';
		 else
			echo 'echec';
	$reponse->closeCursor();			
?>
