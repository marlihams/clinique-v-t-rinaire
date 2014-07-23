<?php
	class Objet1
	{
		private $this.identifiant;
		private $this.motDePasse;
		private $this.message;
		private $this.creation;
		
		public __construct($iden,$mot=" ",$mes=" ")
		{
			 $this.identifiant=$iden;
		 $this.motDePasse=$mot;
		 $this.message=$mes;
		}
		public getIdentifiant(){return $this.identifiant;}
		public getMotDePasse(){return $this.motDePasse;}
		public getMessage(){return $this.message;}
		public connection($baseDonne)
		{
			$this.creation=new PDO('msql:host=localhost;dbname='+.$baseDonne,'root','');
			
		}
		public requeteTake($requete,$tab)
		{
			$rep=$this.creation->prepare($requete);
			$rep=$this.creation->excecute($tab)or die(print_r($rep.erreurInfo()));
			return $rep;
		}
		public requetePut($requete,$tab)
		{
			$this.requeteTake($requete,$tab);
		}			
	};
?>
