
var OLD={};
var GLOBALE={};
var oldRdv={};
var veterinaire={};
// evenement associé a l'affichage du calendrier
$(function(){
	var tableau=$("#calendrier");
	$("#aff").on({
		click:function(){
		tableau.slideToggle("slow");
	},
	mouseenter:function(){
	$(this).css("color","red");
	},
	mouseleave:function(){
	$(this).css("color","green");
	}
});
});

// utilisation du plugin datepicker 
$(function(){
$( "#datepicker" ).datepicker({
	dateFormat:"yy-mm-dd",
	showAnim:"slideDown",
	duration:"normal",
	buttonImage:"../dossierCSS/images/calendrier.png"
	});
});

function envoieDonne(donnee)
{
$.ajax({
			url:'phpCalendrier.php',
			type:'POST',
			data: donnee,
			dataType:"json",
			success: function(d){
				fonctPHP(d);
			},
			error: function (data, statut,erreur){

		alert(data +" : "+ status + " "+erreur);
			}
		});	
}

function estEmpty(obj){
return obj.length == 0;
}

function entete() {
 var nom= $("#vet").val();
	var nom=nom.split('.');

	$("#tableau caption").html("emploi de temps de Mr : <strong>"+nom[1]+" </strong> ");
}
entete();
$(function(){

$("#vet").change(function()
{
	entete();

});
});
function fonctPHP(data)
{
			var tableau=data["date"];
			 var titre= data["info"];
		if (!estEmpty(tableau) && !estEmpty(titre))
	{
				var td=0;
				var valeur;
				var begin=findDay();
				$.each(tableau,function(td,tab)
				{		
					valeur=tab[0];		
					td=parseInt(td);
					td=td+begin;
					td=td%7;
					if (td && td<6)
					{
							if (valeur >=8 &&  valeur < 9 ) tr=1;
							 else if (valeur >=9 &&  valeur < 10)  tr=2 ;
							 else if (valeur >=10 &&  valeur <11)  tr=3 ;
							  else if (valeur >=11 &&  valeur <12) tr=4;
							 else if (valeur >= 14 &&  valeur <15 ) tr=5 ;
							 else if (valeur >= 15 &&  valeur <16)  tr=6;
							 else if (valeur >=16 &&  valeur < 17)  tr=7 ;
							 else if (valeur >=17 &&  valeur < 18)  tr=8 ;
							else tr="a"; 
								
						if (tr !=="a")
						{
							var cellule= $('#tableau').find('tr:eq('+tr+') td:eq('+td+')');
							if (cellule.attr('alt')!="faux")
								{
						 			cellule.html("<img src='../imageProjet/faux.jpeg' alt='faux' />");
								}
							 else
							  {
									alert("Echec");
								}
								
						}
						
					 }
				});
	}
}
function isEmpty(){
return (Object.getOwnPropertyNames(oldRdv).length === 0);
}

function remiseZero()
{
		 $('#tableau td[alt="faux"]').each(function(){
				$(this).html("<img src='../imageProjet/vrai.jpeg' alt='vrai' />");
		});		 
}
$(function(){
 var idatepicker=$(".idatepicker");
	idatepicker.change(function(){
	GLOBALE['debut']=$(this).val();
		miseAJourDate(); // trouve la  prochaine semaine;	
			var nom=$("#vet").val();
			var nom=nom.split(".");
			var id="id="+nom[0]+"&";
			var nvDebut=id+'debut='+''+GLOBALE["debut"];
		 remiseZero();
			 envoieDonne(nvDebut);	
	var titre=$("#tableau caption").html();
	 $("#tableau caption").val(titre + " <mark>"+GLOBALE["interval"]+"</mark>");
	});
});

function findDay()
{
	var date=new Date(GLOBALE["debut"]);
	 return date.getDay() ;
}
// mise à jour de la date 

function miseAJourDate ()
{
	 var date=new Date(GLOBALE["debut"]);
    var newdate=date.getTime();
	GLOBALE["interval"]=(function(){

		var int1= new Date( GLOBALE["debut"]).toLocaleString();
		var int2= new Date(GLOBALE["debut"]+7*24*3600*1000).toLocaleString();
		int1=int1.split(" ");
		int2=int2.split(" ");
		int1=int1.slice(0,4)
		int2=int2.slice(0,4);
		return int1.join(" ")+" au "+int2.join(" ");
	})();
GLOBALE['debut']=newdate;
}
function ResultReservation()
{
var retour=0;
	var td=findDay();
	var val=$("#heure").val();
	 val.split("h");
	switch(val[0])
	{
		case 8: tr=1; break;
		case 9: tr=2; break;
		case 10:tr=3;break;
		case 11: tr=4; break;
		case 14: tr=5; break;
		case 15: tr=6; break;
		case 16: tr=7 ;break;
		case 17: tr=8 ;break;
		default: tr="a"; break;
	}
	 if (tr!="a")
	 {
		 var cellule= $('#tableau').find('tr:eq('+tr+') td:eq('+td+')');
				if (cellule.attr('alt')!="faux")
					{
						 cellule.html("<img src='../imageProjet/faux.jpeg' alt='faux' />");
						retour=1;
					}
	 }
return retour;
}

