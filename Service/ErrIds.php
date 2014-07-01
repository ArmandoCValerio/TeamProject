<?php

	//Klassen sind immer public
	//Eigenschaften können private, public, protected
	class ErrIds
	{	
		const  cOK					= 0;
		const  cNOK 	         	= 1;
		
		const  cErrRecordChanged    = 2;
		const  cErrRecordNotFound	= 3;
		const  cErrWrongData		= 4;
		const  cErrTableEmpty		= 5;
		
		const  cErrWrongParamter	= 10;
		const  cErrPageNotFound 	= 11;
		const  cErrInvalidRequest	= 12;
		const  cErrServerError		= 13;
		const  cErrUndefClass		= 14;
		
		
		//Datenbank und SQL Fehler
		const  cErrDBConnect    	= 100;
		const  cErrDBClose          = 101;
		const  cErrDBCharset    	= 102;
		const  cErrDBQuery      	= 103;
		const  cErrDBFetch      	= 104;
		const  cErrDBBFetchRow     	= 105;

	}
?>