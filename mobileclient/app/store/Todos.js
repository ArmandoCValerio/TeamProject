Ext.define('Todoliste.store.Todos', 
{
	extend: 'Ext.data.Store',
	config: 
	{
		proxy:
		{
			type: 'rest',
			url: '/bwi2131012/service/todos',
			reader: 
			{
				type: 'json'
			},
		
			listeners: 
			{
				exception: function(proxy, request)
				{
					Ext.Msg.alert('Fehler', request.statusText);
				}	
			}
		},	
		
		model: 'Todoliste.model.Todo',		
		autoLoad: true
	}
});
