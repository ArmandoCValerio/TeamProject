$.widget("kontakt.menuBar", 
{
	_create: function()
	{
		var that = this;
		this.element.find(".show_kontakte").click(function()
		{
			that._trigger("onShowKontakteClicked");
		});

		this.element.find(".create_kontakt").click(function()
		{
			that._trigger("onCreateKontaktClicked");
		});

	}
});
