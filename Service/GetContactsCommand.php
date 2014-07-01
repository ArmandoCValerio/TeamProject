<?php
	//Globale für SQL
	$sqlLimitFrom;			//ab welchem Record gelsen werden soll init=0
	$sqlLimitTo;			//Anzahl Records die gelesen werden

	class GetContactsCommand 
	{
	
		public function execute($request,$requestHeaders,&$arrRecs)
		{
			global $sqlLimitFrom,$sqlLimitTo;
			$sqlLimitFrom	= 0;
			$sqlLimitTo	    = 10;
			
			$csObj  = new ContactService();
			//$errObj = new ErrHandling();
			
			$retC = $csObj->maxPageCnt($maxPages);
			var_dump($maxPages);
		
			$retC = $csObj->readContacts($arrRecs);
			//if ($retC != errIds::cOK)
			//{
			//	$errText = $errObj->getErrText($retC);
			//	var_dump("ErrorCode:",$retC," ",$errText);
			//	//header("HTTP/1.1 500");
			//	return;
			//}
			if ($retC == errIds::cOK)
			{
				foreach ($arrRecs as $contact)
				{
					//$contact->url = "/bwi2131012/contact/$contact->cId";
					$contact->url = "/TeamProject/Service/contact/$contact->cId";
					unset($contact->cId);
				}			
			}
			return $retC;	
		}
		
	}

?>