$.widget("kontakt.editDialog",$.ui.dialog, 
{  			// Definiton des Widgets mit Name ""
    options:
	{
		autoOpen: false,
		modal: true,
		width: 550
	},
	
	open: function(todo)
	{
		
		this._kontakt = kontakt;											//Stellt dieser Instanz das Attribut todo zur Verfügung 
		this.element.find("#title_field").removeClass("ui-state-error").val(todo.title);	//CSS-Class entfernen
		this.element.find(".validation_message").empty();									//Entfernen des Textes
		this.element.find("#title_field").val(todo.title);
		this.element.find("#due_date_field").val(todo.due_date);
		this.element.find("#notes_field").val(todo.notes);
		this.element.find("#author_field").val(todo.author);
		this._super();
	},
	
	_create: function()
	{
		var that = this;
		this.options.buttons = [
		  {
		    text: "OK",
			click: function()
			{
				that._updateKontakt();
			}
		  },
		  {
		    text: "Abbrechen",
  		    click: function()
		    {
			  that.close();
			  that._trigger("onKontaktCanceled");
		    }
		  }
		];
	
	this._super();
	
	},
	
	_updateKontakt: function()
	{
		var todo = 
		{
			title: this.element.find("#title_field").val(),
			due_date: this.element.find("#due_date_field").val(),
			notes: this.element.find("#notes_field").val(),
			author: this.element.find("#author_field").val(),
		};
		
		$.ajax(
		{
		   type: "PUT",
		   url: this._kontakt.url,
		   headers: {"If-Match": this._kontakt.version },
		   data: kontakt,
		   
		   success: function()
		   {
			  this.close();
			  this._trigger("onKontaktEdited");
		   },
		   
		   error: function(request)
		   {
				this.element.find("#title_field").removeClass("ui-state-error").val(todo.title);	//CSS-Class entfernen
				this.element.find(".validation_message").empty();									//Entfernen des Textes

				if  (request.status == "400")
				{
					var validationMessages = $.parseJSON(request.responseText);
					if  (validationMessages.title)
					{
						this.element.find(".validation_message").text(validationMessages.title);
						this.element.find("#title_field").addClass("ui-state-error").focus();
					}
				}
		   },
		   
		   context: this
		});		
		
	}		
});		
