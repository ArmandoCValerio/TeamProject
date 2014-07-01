$.widget("kontakt.deleteDialog", $.ui.dialog,
{  
  options: 
  {
  autoOpen: false, // fenster nicht öffnen bei instanziierung
  modal: true // modal = behält Fokus auf dem Widget, bis "ok" gedrückt wird
  },
  
  open: function(kontakt)
  {
	this._kontakt = kontakt; // Klassen-Attribut als temporäre Variable nutzen
	this._super();
  },
  
  _create: function() 
  {
	// "this" bezieht sich innerhalb des Click-Handlers NICHT MEHR auf das 
	// Widget an sich, daher für den Zugriff in "that" zwischenspeichern
	var that = this;
	this.options.buttons = [ // <- Dies ist ein Array aus Buttons
	{		
		text: "Abbrechen",
		click: function()
		{
		that.close();
		}
		
	},
	 
	{		
		text: "Ok",
		click: function()
		{
			that._deleteKontakt();
			that.close();
		}
	}];
	  // Überschriebene Methode mit gleichem Namen ausführen
	  this._super();
  },

  _deleteKontakt: function()
  {
	$.ajax(
	{
		type: "DELETE",
		url: this._kontakt.url,
		success: function()
		{
			this._trigger("onKontaktDeleted");
		},
		context: this
	});
	//alert("Kontakt gelöscht");
  }    
  
});