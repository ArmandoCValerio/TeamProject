<?php
	
	class GetContactCommand 
	{
		public function execute($request,$requestHeaders,&$dbRec)
		{
			$retC = errIds::cOK;
			
			$Id 	 = 0; //Initialisieren
			if (isset($request["id"]))
			{
				if  (is_numeric($request["id"]))
				{
					$Id  = $request["id"];
				} else 
					{
						$retC = errIds::cErrWrongParamter;
					}
			} else
				{
					$retC = errIds::cErrWrongParamter;
				}
			
			if ($retC == errIds::cOK)
			{			
				$clsObj  = new ContactService();  
				//$errObj = new ErrHandling();
				
				$retC = $clsObj->readContactDetail($dbRec,$Id);
				//if ($retC != errIds::cOK)
				//{
				//	$errText = $errObj->getErrText($retC);
				//	var_dump("ErrorCode:",$retC," ",$errText);
				//	//header("HTTP/1.1 500");
				//	return;
				//}
				if ($retC == errIds::cOK)
				{
					$dbRec->url = "/TeamProject/Service/contact/$dbRec->cId";
					unset($dbRec->cId);
					header("Etag: $dbRec->cVersion");
					unset($dbRec->cVersion);
				}
			}
			return $retC;	
		}
	}

?>