<?php

		//Global für Datenbank Connection
		$gLink;
		$gTable;
		$gDbName;
		$gPassW;
		$gUser;
		$gHost;
		
	class DBCommand
	{			
		public function DBCommand()
		{
			global $gHost,$gUser,$gPassW,$gDbName,$gTable;
			$gHost 		= "localhost";
			$gUser		= "root";
			$gPassW 	= "";	
			$gDbName	= "cmdb";
			$gTable  	= "contacts";
		}
		
		
		public function dbConnect()
		{
			global $gLink,$gHost,$gUser,$gPassW,$gDbName;
			
			@$gLink     = new mysqli($gHost,$gUser,$gPassW,$gDbName);
			if  ($gLink->connect_error != NULL)
			{
				return ErrIds::cErrDBConnect;
			}
			return ErrIds::cOK;	
		}
		
		public function dbClose()
		{
			global $gLink;
			
			$retC = $gLink->close();
			if ($retC == FALSE)
			{
				return ErrIds::cErrClose;
			}
			return ErrIds::cOK;
		}	
		
		public function dbCharSet()
		{
			global $gLink;
			
			$retC = $gLink->set_charset("utf8");
			if ($retC === FALSE)
			{
				return ErrIds::cErrDBCharset;
			}
			return ErrIds::cOK;
		}
		
		public function dbQuery(&$resSet,$sqlState)
		{
			global $gLink;
			
			$resSet   = $gLink->query($sqlState);
			if  ($resSet === FALSE)
			{
				return ErrIds::cErrDBQuery;
			}
			return ErrIds::cOK;
		}
		
		public function dbFetch($resSet,&$dbRec,$tab)
		{

			$dbRec     = $resSet->fetch_object($tab);		
			if  ($dbRec === FALSE)
			{
				return ErrIds::cErrDBFetch;
			} else if ($dbRec == NULL)
				{
					return ErrIds::cErrRecordNotFound;
				}
			
			return ErrIds::cOK;
		}
		
		public function dbFetchRow($resSet,&$dbRec)
		{
			
			$dbRec = $resSet->fetch_row();
			if  ($dbRec === FALSE)
			{
				return ErrIds::cErrTableEmpty;
			} else if ($dbRec == NULL)
				{
					return ErrIds::cErrDBBFetchRow;
				}
			
			return ErrIds::cOK;
		}
	}
?>