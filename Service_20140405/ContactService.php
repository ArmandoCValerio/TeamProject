<?php
	//Globale für Sortierung und Richtung
	$gOrderBy  = "cName";
	$gOrderDir = "ASC";
	
	class ContactService 
	{	
		
		//Mehrere Kontakte lesen: Von - Bis
		public function readContacts(&$arrRecs)
		{
			global $gLink,$gTable;
			global $gOrderBy,$gOrderDir;
			global $sqlLimitFrom,$sqlLimitTo;
			
			$dbObj   = new DBCommand();
			
			$sqlState = "SELECT cId, cCrtDate, cCrtUser, cUpdtDate, " . 
								"cUpdtUser, cName, cBirthDay, cCity, " . 
								"cMail, cPhone, cNotes, cVersion " .
								"FROM ". $gTable . " " .
								"ORDER BY " . $gOrderBy . " " . $gOrderDir . " " .			
								"LIMIT " . $sqlLimitFrom . " , " . $sqlLimitTo;
			
			$retC = $this->prepareConnect($dbObj,$resSet,$sqlState);
			if  ($retC == ErrIds::cOK)
			{
				$retC = $dbObj->dbFetch($resSet,$dbRec,$gTable);
				while (($dbRec != NULL) and ($retC == ErrIds::cOK))		
						{
							$arrRecs[]  = $dbRec;
							$retC = $dbObj->dbFetch($resSet,$dbRec,$gTable);
						}
			}
			if  (($arrRecs != NULL) and (ErrIds::cNOK))
			{
				$retC = ErrIds::cOK;
			}
			$retC = $this->prepareClose($dbObj,$retC);
			return $retC;
		}
				
	
		//Kontakt mir ID lesen
		public function readContactDetail(&$dbRec,$lId)
		{
			global $gLink,$gTable;
			$dbObj  = new DBCommand();
						
			$sqlState = "SELECT cId, cCrtDate, cCrtUser, cUpdtDate, " . 
						"cUpdtUser, cName, cBirthDay, cCity, " . 
						"cMail, cPhone, cNotes, cVersion " .
						"FROM ". $gTable . " " .
						"WHERE cId = " . $lId;
			
			$retC = $this->prepareConnect($dbObj,$resSet,$sqlState);
			if  ($retC == ErrIds::cOK)
			{
				$retC = $dbObj->dbFetch($resSet,$dbRec,$gTable);
			}
			$retC = $this->prepareClose($dbObj,$retC);
					
			return $retC;
		}
		
		//UPDATE vorbereiten
		public function updateContact(&$dbRec,$lId)
		{
			global $gLink,$gTable;
			$dbObj  = new DBCommand();
						
			$retC = $this->readContactDetail($dbRec,$lId);
			if  ($retC == ErrIds::cOK)
			{
				//Prüfen ob Record zwischenzeitlich geändert wurde! entweder Felder vergleichen oder mittels TimeStamp!
				if  ($dbRec->cVersion == $dbRec->cVersion)
				{
					$sqlState = "UPDATE " . $gTable . " SET " .
					             "cId, cCrtDate, cCrtUser, cUpdtDate, " . 
								 "cUpdtUser, cName, cBirthDay, cCity, cMail, cNotes, " .
								 "cVersion = cVersion + 1 ".
								 "FROM ". $gTable . " " .
								 "WHERE cId = " . $lId;
								
					$retC = $this->prepareConnect($dbObj,$resSet,$sqlState);
					$retC = $this->prepareClose($dbObj,$retC);
				} else 
					{
						$retC = ErrIds::cErrRecordChanged;
					}
			}	
	
			return $retC;
		}
		
		/* 
			METHODE INSERT vorbereiten
		*/
		public function insertContact(&$dbRec)
		{
			global $gTable;
			$dbObj  = new DBCommand();
			$errObj = new ErrHandle();
			
			//Prüfen ob Felder in Ordnung
			$retC = $this->validationParam($errObj,$dbRec->cName);
			if  ($retC == ErrIds::cOK)
			{
				$retC = $this->validationParam($errObj,$dbRec->cCity);
			}
			if  ($retC == ErrIds::cOK)
			{
				$retC = $this->validationParam($errObj,$dbRec->cBirthDay);			
			}
			
			if  ($retC == ErrIds::cOK)
			{
				$sqlState = "INSERT INTO " . $gTable . " SET " . 
													  "cCrtDate = CURDATE(), " .
												      "cCrtUser = '$dbRec->cCrtUser', " .
												      "cUpdtDate = CURDATE(), " .
												      "cUpdtUser = '$dbRec->cUpdtUser', " .
												      "cName = '$dbRec->cName', " .
												      "cBirthDay = '$dbRec->cBirthDay', " .
												      "cCity = '$dbRec->cCity', " .
												      "cMail = '$dbRec->cMail', " .
													  "cPhone = '$dbRec->cMail', " .
												      "cNotes = '$dbRec->cNotes', " .
													  "cVersion = 1";
													  
				$retC = $this->prepareConnect($dbObj,$resSet,$sqlState);
				$retC = $this->prepareClose($dbObj,$retC);
			} else 
				{
					$retC = ErrIds::cErrWrongData;
				}

			return $retC;
		}
		
		//DELETE vorbereiten
		public function deleteContact(&$dbRec,$lId)
		{
			global $gLink,$gTable;
			$dbObj  = new DBCommand();
			
			$retC = $this->readContactDetail($dbRec,$lId);
			if  ($retC == ErrIds::cOK)
			{
				//Prüfen ob Record zwischenzeitlich geändert wurde! entweder Felder vergleichen oder mittels TimeStamp!
				if  ($lId == $dbRec->$cId)
				{
					$sqlState   = "DELETE FROM " . $gTable . " WHERE cId = " . $lId;
					$retC = $this->prepareConnect($dbObj,$resSet,$sqlState);
					if  ($retC == ErrIds::cOK)
					{
						 $affRows = $link->affected_rows;
						 if  ($affRows == 0)
						 {
							$retC = ErrIds::cErrRecordNotFound;
						 }
					}	
					$retC = $this->prepareClose($dbObj,$retC);
				} else 
					{
						$retC = ErrIds::cErrRecordChanged;
					}	
			}
			return $retC;
		}
		
		//Anzahl der Seiten ermitteln
		public function maxPageCnt(&$maxPages)
		{
			global $gTable,$sqlLimitTo;
			$dbObj   = new DBCommand();
			
			$sqlState = "SELECT COUNT(*) FROM " .$gTable;
			
			$retC = $this->prepareConnect($dbObj,$resSet,$sqlState);
			if  ($retC == ErrIds::cOK)
			{
				$retC = $dbObj->dbFetchRow($resSet,$dbRec);
				if  ($retC == ErrIds::cOK)
				{
					$dbRec 	  = $dbRec[0];
					$maxPages = ceil($dbRec / $sqlLimitTo); 
				}
			}
			
			$retC = $this->prepareClose($dbObj,$retC);
			return $retC;
		}

		//Datenbank Connect vorbereiten und SQL-QUERY-Befehl absetzen
		public function prepareConnect($dbObj,&$resSet,$sqlState)
		{
			
			$retC = $dbObj->dbConnect();
			if  ($retC == ErrIds::cOK)
			{
				$retC = $dbObj->dbCharSet();
				if  ($retC == ErrIds::cOK)
				{
					$retC = $dbObj->dbQuery($resSet,$sqlState);
				}
			}
			return $retC;
		}
		
		//Datenbank Close vorbereiten
		public function prepareClose($dbObj,$retC)
		{
			global $gLink;
			
			if  ($gLink->connect_error == NULL)
			{
				$retClose = $dbObj->dbClose();
				if  ($retC == ErrIds::cOK)			//eventuell vorheriger Fehler weiterreichen
				{
					return $retClose;
				}
				return $retC;
			}
		}
		
		public function validationParam($errObj,$field)
		{
			$retC = ErrIds::cOK;
			
			if  ($field == "")
			{
				$retC   = ErrIds::cErrWrongData;
				$errObj->validationMessage[$field] = $field . " ist ein Pflichtfeld!";
			}
		
			return $retC;
		}
		
	}

?>