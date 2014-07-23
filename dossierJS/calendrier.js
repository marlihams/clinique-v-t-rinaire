var OLD={};
var GLOBALE={};
var oldRdv={};
var veterinaire={};
$(function(){
$( ".datepicker" ).datepicker({
	dateFormat:"yy-mm-dd",
	showAnim:"slideDown",
	duration:"normal",
	buttonImage:"../dossierCSS/images/calendrier.png"
	});
});
$('#valider').click(function()
{
	var bool=1;
		$('#debut').each(function(){
				$(this).val()=="" ?(messageErreur($(this)), bool=0):"";
			 });
				if (bool)
			 {
				$("#resultat p").css("display","hidden");
				$("#photo").css("display","inline-block");
				var chaine=$("#debut").val();
			GLOBALE["debut"]=chaine;
			miseAJourDate(1);
				//var donnee="id="+$("#id").val()+"debut="+GLOBALE["debut"];
		var donnee="debut="+GLOBALE["debut"];
			GLOBALE["debut"]=OLD["fin"];
				envoieDonne($(this),donnee);
				 
		}
});

function envoieDonne(objet,donnee)
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

function messageErreur(objet)
{
  $("#resultat p").css("display","block");
  objet.css("border","0.5px solid red");
}
$("#menu a,.previous,.next").on({
	click:function(){
	$("#resultat").css("display","inline-block");
	$(this).css("color","#a36f38");
	},
	mouseenter:function(){
		$(this).hoverFade();
	}
});
function estEmpty(obj){
return obj.length == 0;
}
function afficheTitre() {
	$("table caption").html("emploi de temps de Mr :"+"<strong>"+veterinaire["nom"]+" "
			  +veterinaire["prenom"]+ " </strong>du <mark>"+GLOBALE["interval"]+"</mark>"); 
}
function fonctPHP(data)
{
			var tableau=data["date"];
			 var titre= data["info"];
		if (!estEmpty(tableau) && !estEmpty(titre))
	{
				veterinaire["nom"]=titre["nom"];
				veterinaire["prenom"]=titre["prenom"];
				afficheTitre();
					$('#resultat').css("display","inline-block");
					$('table').css("display","inline-block");
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
							oldRdv[tr]=td;
							var cellule= $('table').find('tr:eq('+tr+') td:eq('+td+')');
							if (cellule.attr('alt')!="faux")
								{
						 			cellule.html("<img src='../imageProjet/faux.jpeg' alt='faux' />");
											cellule.tooltipster({
										interactive:true,										  
					content:$('<p>rendez-vous avec 	<mark> '+tab[1]+'</mark><br/><a href=../dossierPHP/veto.php?numero='+parseInt(tab[2])+'>pour plus dinfo cliquez sur ce lien</a></p>'),
									trigger:'hover'
					 });
								}
								
						}
						
					 }
				});
	}
	else
	{
		afficheTitre();
	}
}
function isEmpty(){
return (Object.getOwnPropertyNames(oldRdv).length === 0);
}
function remiseZero()
{
	 if (!isEmpty())
	 {
		 $.each(oldRdv,function(indice , valeur)
		 {
			 var cellule= $('table').find('tr:eq('+indice+') td:eq('+valeur+')');
			 if (cellule.attr('alt')!="vrai")
			{
				cellule.html("<img src='../imageProjet/vrai.jpeg' alt='vrai' />");
			}
		});
	}		 
}
$(function (){
	
	$("#photo .next , #photo .previous").each(function(){
	$(this).click(function(){
		var indice=1;
		var objet=$("table");
		 if ($(this).attr('class')=='next')
		{
			 objet.tabSlide({'finale':'100%','initiale':'-70%'});
		}
		else
		{
			objet.tabSlide({'finale':'-70%','initiale':'100%'});
			indice=0;
		}
			miseAJourDate(indice); // trouve la  prochaine semaine;		
			var nvDebut='debut='+''+GLOBALE["debut"];
		 remiseZero();
			 envoieDonne($(this),nvDebut);
		GLOBALE["debut"]= (indice==1? OLD["fin"]:OLD["debut"]);
		});
		
	});
});

function findDay()
{
	var date=new Date(GLOBALE["debut"]);
	 return date.getDay() ;
}
// mise à jour de la date 

function miseAJourDate (indice)
{

	 var date=new Date(GLOBALE["debut"]);
    var newdate=date.getTime();
    var old=newdate;
    if (!indice)
		{
			OLD["fin"]=old;
			newdate=date.getTime()-(7*24*3600*1000);
       OLD["debut"]=newdate;    
		}
 					date.setTime(newdate);
            GLOBALE["debut"]=date.getTime();
       if (newdate==old)
       {
          OLD["debut"]=newdate;
	      	OLD["fin"]=newdate+(7*24*3600*1000);
       }
	GLOBALE["interval"]=(function(){
		var int1= new Date( OLD["debut"]).toLocaleString();
		var int2= new Date(OLD["fin"]).toLocaleString();
		int1=int1.split(" ");
		int2=int2.split(" ");
		int1=int1.slice(0,4)
		int2=int2.slice(0,4);
		return int1.join(" ")+" au "+int2.join(" ");
	})();
}

