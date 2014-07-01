Ext.define('Todoliste.model.Todo', 
{
	extend: 'Ext.data.Model',
	config: 
	{
		fields: 
		[
			{
				name: 'title'
			},
			{
				name: 'author'
			},
			{
				name: 'due_date',
				type: 'date'
			},
			{
				name: 'notes'
			}
		]
	}
});
