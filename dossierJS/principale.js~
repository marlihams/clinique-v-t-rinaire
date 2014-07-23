$(function() {
$( "#tabs" ).tabs({
	heightStyle:"content",
	active: 0 ,
	show: { effect: "blind", duration: 800 }
	}).addClass( "ui-tabs-vertical ui-helper-clearfix" );
$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left");
});
  $("#galerie").imageSlide();
   
 var namespace={
				
	 erreur:function(objet,a)
	 {
			
		if (!a)
		{
			objet.css({
			border:"1px solid red",
			});
		}
	 },
	 displayErreur:function(id)
	 {
		 var objet=$("#identification");
			objet.find(".erreur")
					.css({
							display:'block',
							textAlign:'center',
							color:'red'
						 }).prependTo(objet);
	 },
	 
	 submitFormAjax:function(objet)
	 {
			$("form").submit();
	 },
		verifDivers:function(val)
		 {
			 return val!='';
		 },
		
	};
function verifierInformation(objet)
{
	var rep=1,res=1;
	objet.each(function(){
		var texte=$(this).val();
		rep=namespace.verifDivers(texte);
		namespace.erreur($(this),rep);
		if (!rep)
		{
			res=0;
		}
	});
	return res;
}

/* ******************************************************* */
function allFormulaire(objet){ // fonction principale
	objet.find(":button").click(function(){
		var aVerifier=objet.find(":input[type!='Button']");
			var result=verifierInformation(aVerifier); 
			if (result)
			{	
				var aj=objet.find('.form');
				
				namespace.submitFormAjax(aj);
			}
			else
			{
				namespace.displayErreur(objet.attr("id"));
			}
	});
} 

 /* ********************************** evenement globale ********************************** */
$("h3,h5,input[type=Button]").hoverFade();

$(function(){
	$("#identification").each(function(){
	
		allFormulaire($(this));
	});
});
