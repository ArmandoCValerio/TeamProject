<?php

class UpdateContactCommand 
	{
		public function execute($request,$requestHeaders)
		{
			$todo  = new Todo();		
			$todo_service = new TodoService();
			
			if  (isset($request["id"]) == TRUE)
			{
				$todo->id  		 = $request["id"];
				if  (isset($request["due_date"]) == TRUE)
				{
					$todo->due_date  = $request["due_date"];
				}
				if  (isset($request["author"]) == TRUE)
				{
					$todo->author    = $request["author"];
				}
				if  (isset($request["notes"]) == TRUE)
				{
					$todo->notes     = $request["notes"];
				}
				if  (isset($request["title"]) == TRUE)
				{
					$todo->title     = $request["title"];
				}
				if  (isset($request_headers["If-Match"]) == TRUE)
				{
					$todo->version = $request_headers["If-Match"];
					$result = $todo_service->updateTodo($todo);
				} else
				{
					return;
				}
				
				if  ($result->status_code == TodoService::NOF)
				{
					header("HTTP/1.1 404");
					return $result->status_code;
				}
				
				if  ($result->status_code == TodoService::errINVALID)
				{	
					header("HTTP/1.1 400");
					return $result->validation_message;
				}
			
				echo '"UPDATE"';
				return;			
			}			
		}	
	}

?>