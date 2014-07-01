Ext.define('Todoliste.view.TodoList', 
{
	extend: 'Ext.dataview.List',
	xtype: 'todolist',
	config: 
	{
		store: 'Todos',
		itemTpl: '<div>{due_date}</div><div>{title}</div>',
		emptyText: 'keine Todos'		
	}
});
