// Befehle in Function werden direkt ausgef�hrt, ohne Instanziierung
// Achtung: Asynchrone Ausf�hrung der darin enthaltenen Befehle
$(function() {	
	// Registrieren einer Funktion, f�r das gesamte HTML $(document)
	// .ajaxError: speziell bei Fehlern in HTTP Kommunikation
	$(document).ajaxError(function(event, request)
	{
		if  (request.status == "400")
		{
			return;
		}
		
		if  (request.status == "412")
		{
			return;
		}
		
		//alert(request.statusText); // Status aus Server-Response
		$("#error_dialog").errorDialog("open", request.statusText);
		
		if (request.status==404) 
		{
			$("#kontakt_liste").show();
			$("#kontakt_details").hide();
			$("#kontakt_liste").kontaktListe("reload");
		}
		
	});
	
		//bei HTTP Anfrage sperren der Oberfl�sche
	$(document).ajaxStart(function()						
	{														
		$.blockUI({ message: null });						
	});

	//bei HTTP Request entsperren der Oberfl�sche
	$(document).ajaxStop(function()					
	{													    
		$.unblockUI({ message: null });						
	});
	
	//Error Dialog Widget
	$("#error_dialog").errorDialog();
	
	//MenuBar
	$("#menu_bar").menuBar(
	{
		onShowKontakteClicked: function()
		{
			$("#kontakt_list").kontaktList("reload");				//Refresh
		},

		onCreateKontaktClicked: function()
		{
			alert("CREATE");
		},
	});
		
	//Dialog beim L�schen
	$("#delete_dialog").deleteDialog(
	{
		onKontaktDeleted: function()
		{
			$("#kontakt_list").kontaktList("reload");				//Refresh
		},
	});
	
	//Dialog f�r das editieren
	$("#edit_dialog").editDialog(
	{
		onKontaktEdited: function()
		{
			$("#kontakt_list").kontaktList("reload");				//Refresh nach editieren
		},

		onKontaktCanceled: function()
		{
			$("#kontakt_list").kontaktList("reload");				//Refresh nach abbruch
		},

	});

	// HTML Element verkn�pfen und Widget namens "todoList" instanziieren
	$("#kontakt_liste").kontaktListe(
		{
		onKontaktClicked: function(event, kontaktUri)
			{
				$("#kontakt_details").kontaktDetails("load", kontaktUri);
				$("#kontakt_liste").hide();
				$("#kontakt_details").show();
				//alert(todoUri);
			},
			
		onDeleteKontaktClicked: function(event, kontakt)
			{
				//alert("delete");
				$("#delete_dialog").deleteDialog("open",kontakt);
			},
	    
		onEditKontaktClicked: function(event, kontakt)
		{
			$("#edit_dialog").editDialog("open",kontakt);
		},	
			
	});
	
	$("#kontakt_details").kontaktDetails(
	{
		onKontaktClicked: function(event,url)
		{
			$("#kontakt_details").hide();
			$("#kontakt_liste").show();
			$("#kontakt_liste").kontaktListe("reload"); //,url);
		}	
	});
	
});