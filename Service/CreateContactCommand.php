<?php

class CreateContactCommand 
	{
		public function execute($request,$requestHeaders,&$dbRec)
		{
			$dbRec  = new Contacts();
			$errObj = new ErrHandle();
			$retC   = ErrIds::cOK;
			
			if (isset($request["cName"]) == TRUE)
			{
				$dbRec->cName = $request["cName"];
			}
			if (isset($request["cBirthDay"]) == TRUE)
			{
				$dbRec->cBirthDay = $request["cBirthDay"];
			}
			if (isset($request["cCity"]) == TRUE)
			{
				$dbRec->cCity = $request["cCity"];
			}
			if (isset($request["cMail"]) == TRUE)
			{
				$dbRec->cMail = $request["cMail"];
			}
			if (isset($request["cPhone"]) == TRUE)
			{
				$dbRec->cPhone = $request["cPhone"];
			}
			if (isset($request["cNotes"]) == TRUE)
			{
				$dbRec->cNotes = $request["cNotes"];
			}

			if ($retC == ErrIds::cOK)
			{			
				$clsObj  = new ContactService();  
				//$errObj = new ErrHandling();
				
				$retC = $clsObj->insertContact($dbRec);
				//if ($retC != errIds::cOK)
				//{
				//	$errText = $errObj->getErrText($retC);
				//	var_dump("ErrorCode:",$retC," ",$errText);
				//	//header("HTTP/1.1 500");
				//	return;
				//}
				if ($retC == ErrIds::cOK)
				{
					$dbRec->url = "/TeamProject/service/contact/$dbRec->cId";
					unset($dbRec->cId);	
					header("HTTP/1.1 201");
					//header("Location: /service/contact/$dbRec->cId");
					//header("Location: /TeamProject/service/contact/$dbRec->cId");					
				}
			}
			
			return $retC;
		}			
	
	}

?>