$.widget("todo.errorDialog", $.ui.dialog,
{  
  options: 
  {
  autoOpen: false,
  modal: true // modal = behält Fokus auf dem Widget, bis "ok" gedrückt wird
  },
  
  // Methode "open" gibt es in Ursprungsklasse "dialog" schon, daher wird diese 
  // hier weiter überschrieben mit zusätzlichen Befehlen
  open: function(message)
  {
	// Überschriebene Methode mit gleichem Namen ausführen
	this.element.find(".message").text(message);
	this._super();
	
  },
  
  _create: function() 
  {
	// "this" bezieht sich innerhalb des Click-Handlers NICHT MEHR auf das 
	// Widget an sich, daher für den Zugriff in "that" zwischenspeichern
	var that = this;
	this.options.buttons = 
	[
	{		
		text: "Schließen",
		click: function()
	    {
		   that.close();
	    }
		
	}
	];
	  // Überschriebene Methode mit gleichem Namen ausführen
	  this._super();
  }

    
  
});