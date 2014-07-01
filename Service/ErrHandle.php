<?php

	//Klassen sind immer public
	//Eigenschaften können private, public, protected
	class ErrHandle
	{	
		public $ErrMessage;	
		public $validationMessage = array();
		
		public function getError($errCode)
		{
			global $link;
			
			switch ($errCode)
			{
				case ErrIds::cNOK:
					 $ErrMessage = "NotExecute";
					 break;
				case ErrIds::cErrRecordChanged:
					 $ErrMessage = "RecordChanged: " . $errCode;
					 break;	
				case ErrIds::cErrRecordNotFound:
					 $ErrMessage = "RecordNotFound: " . $errCode;
					 header("HTTP/1.1 404");
					 break;
				case ErrIds::cErrWrongData:
					 $ErrMessage = "Wrong or missing Data: " . $errCode;
					 break;
				case ErrIds::cErrTableEmpty:
					 $ErrMessage = "Empty Table" . $errCode;
					 break;
			    case ErrIds::cErrPageNotFound:
					 $ErrMessage = "PageNotFound";
					 break;				
				case ErrIds::cErrInvalidRequest:
					 $ErrMessage = "InvalidRequest";
					 break;
				case ErrIds::cErrServerError:
					 $ErrMessage = "ServerError";
					 break;
				case ErrIds::cErrUndefClass:
					 $ErrMessage = "Undefined Class: " . $errCode;
					 break;
				case ErrIds::cErrWrongParamter:
					 $ErrMessage = "Wrong Paramter: " . $errCode;
					 header("HTTP/1.1 400");
					 break;
				case ErrIds::cErrDBConnect:
					 $ErrMessage = "Connect failed: " . $link->connect_error . ": " . $link->connect_errno;
					 break;
				case ErrIds::cErrDBClose:
					 $ErrMessage = "Close failed: " . $errCode;
					 break;
				case ErrIds::cErrDBCharset:
					 $ErrMessage = "Charset failed: " . $errCode;
					 break;
				case ErrIds::cErrDBQuery:
					 $ErrMessage = "Query failed: " . $errCode;
					 break;
				case ErrIds::cErrDBFetch:
					 $ErrMessage = "FetchObject failed: " . $errCode;
					 break;
				case ErrIds::cErrDBBFetchRow:
					 $ErrMessage = "FetchRow failed: " . $errCode;
					 break;
				default: 
					$ErrMessage = "unknown Error: " . $errCode;
					break;
			}
			return $ErrMessage;
		}
		
	}
?>