<?php
	require "Contacts.php";					//  ""   für Kontakte
	require "ErrIds.php";					//  ""   mit Error Ids
	require "ErrHandle.php";				//  ""   für zentrale Fehlerbehandlung
	require "DBCommand.php";					//  ""   mit Datenbank(SQL)-Methoden
	require "ContactService.php";			//  ""   mit Funktionen
	require "GetContactCommand.php";		//  ""   für ein Kontakt
	require "GetContactsCommand.php";		//  ""   für mehrere Kontakte
    require "CreateContactCommand.php";
	require "DeleteContactCommand.php";
	require "UpdateContactCommand.php";	
	
	//Instanz der Klasse RequestHandler
	$reqHndl = new RequestHandler();	
	//Aufruf der Methode der Klasse ReqHandler
	$reqHndl->handleRequest();	
	
	class RequestHandler 
	{
	
		public function handleRequest()
		{
			$errObj = new ErrHandle();		
			$retC   = ErrIds::cOK;
			
			$request = $_REQUEST;		
			if ($_SERVER["REQUEST_METHOD"] == "PUT") 
			{
			  parse_str(file_get_contents("php://input"), $body_parameters);
			  $request = $request + $body_parameters;
			}
			$requestHeaders = apache_request_headers();			
			
			$clsObj  = $request["command"];
			if (class_exists($clsObj)) 
			{
				$command = new $clsObj;
			} else 
				{
					$retC = ErrIds::cErrUndefClass;
				}
				
			
			if ($retC == ErrIds::cOK)
			{							
				$retC = $command->execute($request,$requestHeaders,$arrRecs);
				if ($retC == ErrIds::cOK)
				{
					if  ($arrRecs !== NULL)
					{
						//formatierung in JSON-Zeichenkette
						echo(json_encode($arrRecs));	
					}
				}	
			}
				
			if ($retC != ErrIds::cOK)
			{
				$errText = $errObj->getError($retC);
				var_dump("ErrorCode:",$retC," ",$errText);
				var_dump("Message: ",$errObj->validationMessage);
				//header("HTTP/1.1 404");
				return $errText;
			}	
		}
	}

		
?>	