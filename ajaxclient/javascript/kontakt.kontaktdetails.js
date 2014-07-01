$.widget("kontakt.kontaktDetails", 
{  			// Definiton des Widgets mit Name ""
    load: function(kontaktUri)
	{		
		$.ajax(
		{	   
		   url: kontaktUri,
		   dataType: "json",
		   success: this._appendKontakt,
		   context: this
		});
	},
	
	_appendKontakt: function(kontakt)
	{
		var that = this;
		//alert(kontakt);
		this.element.find(".nname").text(kontakt.cVName);
		this.element.find(".vname").text(kontakt.cNName);
		this.element.find(".company").text(kontakt.cCompany);
		this.element.find(".city").text(kontakt.cCity);
		this.element.find(".birthday").text(kontakt.cBirthDay);
		this.element.find(".mail").text(kontakt.cMail);
		this.element.find(".phone").text(kontakt.cPhone);
		this.element.find(".crtdate").text(kontakt.cCrtDate);
		this.element.find(".crtuser").text(kontakt.cCrtUser);
		this.element.find(".updtdate").text(kontakt.cUpdtDate);
		this.element.find(".updtuser").text(kontakt.cUpdtUser);
		//this.element.find(".age").text(kontakt.cAge);  ? wird doch berechnet ? sollte dies nciht im Client passieren ?
		this.element.click(kontakt.url, function(event)
			{
				that._trigger("onKontaktClicked", null, event.data);
			});
    }
});