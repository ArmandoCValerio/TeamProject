<?php

class DeleteContactCommand 
	{
		public function execute($request,$requestHeaders)
		{
			$todo  = new Todo();
			
			if  (isset($request["title"]) == TRUE)
			{
				$id = $request["id"];
			}
			$clsObj  = new ContactService();  
			$retC = $clsObj->deleteContact($id);
			
			if  ($result->status_code == TodoService::errINVALID)
			{
				header("HTTP/1.1 400");
				return $result->validation_message;
			}
			
			//} else
			//	{
			//		header("HTTP/1.1 400");
			//		return "Parameter falsch!";
			//	}
				
			
//			var_dump($id);
//			return;
			header("HTTP/1.1 201");
			header("Location: /service/todos/$result->id");
			return $retC;
		}	
	
	}

?>