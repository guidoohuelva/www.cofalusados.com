<?php
/* ASTEGconsultores 
 * Esta clase DEFINE UN CRUD
 */
class ASTEG_database
{
	//---- CONSTRUCTOR
	public function __construct()
	{
	}
	

	public function database_create($table, $requestArray)
	{
		/* ASTEGconsultores FUNCTION
		 * database_create - inserts a single recordset on the selected table
		 *  
		 * 		$table:string 		| names the table the record is inserted
		 * 		$resultArray 		| array with the information to be inserted, each item name MUST BE EXACTLY the same as the name of the recordfield
		 * 		@returns [TRUE] an array with an item named 'result' and the inserted ITEM 'ID' 
		 * 		@returns [FALSE] an array with a single item namely 'result' = false
		 */
		global $db;
		$returnArray								= array();
		$returnArray['result']					= false;

		$tableQuery 								= "SELECT * FROM ".$table;
		$selectQuery	= $db->Execute($tableQuery);
		$insertQuery	= $db->GetInsertSQL($selectQuery,$requestArray);
		if ($db->Execute($insertQuery))
		{
			$returnArray['result']					= true;
			$returnArray['ID']						= $db->Insert_ID();
		}
		
		return $returnArray;
	}

	public function database_read($table, $requestArray)
	{
		/* ASTEGconsultores FUNCTION
		 * database_read - fetches a single recordset from a selected table
		 *  
		 * 		$table:string 		| names the table the record is fetched from
		 * 		$resultArray 		| array that sends the two methods for retrieving the recordset:
		 * 			$resultArray['ID']	| selects the recordset via the ID
		 * 			$resultArray['FIELDNAME'] $resultArray['FIELDCRITERIA']	| selects the recordset via a named field and the value seeked
		 * 		@returns [TRUE] as an item of the array and the recordset as an array named field0 .. field#
		 * 		@returns [FALSE] as an item of the array
		 */
		global $db;

		$returnArray								= array();
		$returnArray['result']					= false;

		if (isset($requestArray['ID']))
			$tableQuery 			= "SELECT * FROM ".$table." WHERE ID=".$requestArray['ID'];
		else
			$tableQuery 			= "SELECT * FROM ".$table." WHERE ".$requestArray['FIELDNAME']."='".$requestArray['FIELDCRITERIA']."'";

		unset($requestArray['FIELDNAME']);
		unset($requestArray['FIELDCRITERIA']);
		
		$selectQuery	= $db->Execute($tableQuery);
		if ($selectQuery->RecordCount() > 0)
		{
			$returnArray['result']					= true;
			for ($i=0; $i < $selectQuery->FieldCount(); $i++)
				$returnArray['field'.$i] = $selectQuery->fields[$i];
		}
	
		return $returnArray;
	}

	public function database_update($table, $requestArray)
	{
		/* ASTEGconsultores FUNCTION
		 * database_update - updates a selected recordset from a selected table
		 *  
		 * 		$table:string 		| names the table the record is fetched from
		 * 		$resultArray 		| array that sends the two methods for retrieving the recordset and the set of items to be updated
		 * 			$resultArray['ID']	| selects the recordset via the ID
		 * 			$resultArray['FIELDNAME'] $resultArray['FIELDCRITERIA']	| selects the recordset via a named field and the value seeked
		 * 		@returns [TRUE] as an item of the array and 'rows_affected' with the affected rows count
		 * 		@returns [FALSE] as an item of the array
		 */
		global $db;

		$returnArray								= array();
		$returnArray['result']					= false;

		if (isset($requestArray['ID']))
			$tableQuery 			= "SELECT * FROM ".$table." WHERE ID=".$requestArray['ID'];
		else
			$tableQuery 			= "SELECT * FROM ".$table." WHERE ".$requestArray['FIELDNAME']."=".$requestArray['FIELDCRITERIA'];
		
		unset($requestArray['FIELDNAME']);
		unset($requestArray['FIELDCRITERIA']);

		$selectQuery		= $db->Execute($tableQuery);
		$updateQuery	= $db->GetUpdateSQL($selectQuery,$requestArray,true);

		if ($db->Execute($updateQuery))
		{
			$returnArray['result']					= true;
			$returnArray['rows_affected']		= $db->Affected_Rows();
		}
		return $returnArray;
	}

	public function database_delete($table, $requestArray)
	{
		/* ASTEGconsultores FUNCTION
		 * database_delete - deletes a selected recordset from a selected table
		 *  
		 * 		$table:string 		| names the table the record is fetched from
		 * 		$resultArray 		| array that sends the two methods for retrieving the recordset and the set of items to be deleted
		 * 			$resultArray['ID']	| selects the recordset via the ID
		 * 			$resultArray['FIELDNAME'] $resultArray['FIELDCRITERIA']	| deletes the recordset via a named field and the value seeked
		 * 		@returns [TRUE] as an item of the array and 'rows_affected' with the affected rows count
		 * 		@returns [FALSE] as an item of the array
		 */
		global $db;

		$returnArray								= array();
		$returnArray['result']					= false;

		if (isset($requestArray['ID']))
			$tableQuery 			= "DELETE FROM ".$table." WHERE ID=".$requestArray['ID'];
		else
			$tableQuery 			= "DELETE FROM ".$table." WHERE ".$requestArray['FIELDNAME']."=".$requestArray['FIELDCRITERIA'];
		
		unset($requestArray['FIELDNAME']);
		unset($requestArray['FIELDCRITERIA']);
		
		$selectQuery		= $db->Execute($tableQuery);
		if ($selectQuery)
		{
			$returnArray['result']					= true;
			$returnArray['rows_affected']		= $db->Affected_Rows();
		}
		
		return $returnArray;
	}

	public function database_list($table, $requestArray)
	{
		/* ASTEGconsultores FUNCTION
		 * database_list - lists as a matrix the resulting recordsets from a select statemen
		 *  
		 * 		$table:string 		| names the table the record is fetched from
		 * 		$resultArray 		| array that sends the two methods for retrieving the recordset 
		 * 			$resultArray['ID']	| selects the recordset via the ID
		 * 			$resultArray['FIELDNAME'] $resultArray['FIELDCRITERIA']	| recordset via a named field and the value seeked
		 * 			$resultArray['FIELDORDER'] | ORDERS list via ASC or DESC
		 * 			$resultArray['FIELDORDERFIELNAME'] | FIELD TO ORDER BY
		 * 		@returns [TRUE] as an item of the array, the 'rowcount' and a matrix with [rowcount]->array(recordset) 
		 * 		@returns [FALSE] as an item of the array
		 */
		global $db;

		$returnArray								= array();
		$returnArray['result']					= false;

		$tableQuery 			= "SELECT * FROM ".$table;
		if (isset($requestArray['ID']))
			$tableQuery 			.= " WHERE ID=".$requestArray['ID'];
		if (isset($requestArray['FIELDNAME']))
			$tableQuery 			.= " WHERE ".$requestArray['FIELDNAME']."=".$requestArray['FIELDCRITERIA'];
		
		if (isset($requestArray['FIELDORDERFIELDNAME']))
				$tableQuery	.= " ORDER BY ".$requestArray['FIELDORDERFIELDNAME'];

		if (isset($requestArray['FIELDORDER']))
				$tableQuery	.= " ".$requestArray['FIELDORDER'];
		
		unset($requestArray['FIELDNAME']);
		unset($requestArray['FIELDCRITERIA']);
		unset($requestArray['FIELDORDER']);
		unset($requestArray['FIELDORDERFIELDNAME']);

		$recordCount	= 0;
		
		$selectQuery		= $db->Execute($tableQuery);

		if ($selectQuery)
		while (!$selectQuery->EOF)
			{
				for ($i=0; $i < $selectQuery->FieldCount(); $i++)
					$returnArray[$recordCount]['field'.$i] = $selectQuery->fields[$i];
				$recordCount ++;	
				$selectQuery->MoveNext();
			}


		$returnArray['result']					= true;
		$returnArray['rowcount']				= $recordCount;
		
		return $returnArray;
	}


	public function database_search_list($table, $requestArray)
	{
		/* ASTEGconsultores FUNCTION
		 * database_list - lists as a matrix the resulting recordsets from a select statemen
		 *  
		 * 		$table:string 		| names the table the record is fetched from
		 * 		$resultArray 		| array that sends the two methods for retrieving the recordset 
		 * 			$resultArray['ID']	| selects the recordset via the ID
		 * 			$resultArray['FIELDNAME'] $resultArray['FIELDCRITERIA']	| recordset via a named field and the value seeked
		 * 			$resultArray['FIELDORDER'] | ORDERS list via ASC or DESC
		 * 			$resultArray['FIELDORDERFIELNAME'] | FIELD TO ORDER BY
		 * 		@returns [TRUE] as an item of the array, the 'rowcount' and a matrix with [rowcount]->array(recordset) 
		 * 		@returns [FALSE] as an item of the array
		 */
		global $db;

		$returnArray								= array();
		$returnArray['result']					= false;

		$tableQuery 			= "SELECT * FROM ".$table;
		if (isset($requestArray['ID']))
			$tableQuery 			.= " WHERE ID=".$requestArray['ID'];
		if (isset($requestArray['FIELDNAME']))
			$tableQuery 			.= " WHERE ".$requestArray['FIELDNAME']." LIKE '%" .$requestArray['FIELDCRITERIA']."%'";
		
		if (isset($requestArray['FIELDORDERFIELDNAME']))
				$tableQuery	.= " ORDER BY ".$requestArray['FIELDORDERFIELDNAME'];

		if (isset($requestArray['FIELDORDER']))
				$tableQuery	.= " ".$requestArray['FIELDORDER'];
		
		unset($requestArray['FIELDNAME']);
		unset($requestArray['FIELDCRITERIA']);
		unset($requestArray['FIELDORDER']);
		unset($requestArray['FIELDORDERFIELDNAME']);

		$recordCount	= 0;
		
		$selectQuery		= $db->Execute($tableQuery);

		if ($selectQuery)
		while (!$selectQuery->EOF)
			{
				for ($i=0; $i < $selectQuery->FieldCount(); $i++)
					$returnArray[$recordCount]['field'.$i] = $selectQuery->fields[$i];
				$recordCount ++;	
				$selectQuery->MoveNext();
			}


		$returnArray['result']					= true;
		$returnArray['rowcount']				= $recordCount;
		
		return $returnArray;
	}
	
	public function database_advanced_query($requestArray)
	{
		/* ASTEGconsultores FUNCTION
		 * database_advanced_query : Advanced query manager
		 *  
		 * 		$requestArray 						| array that sends the SQL query and special parameters
		 * 		$requestArray['query']				| SQL query to be executed
		 * 
		 * 		@returns $returnArray['result'] 			=	[TRUE]   if the query was executed
		 * 		@returns $returnArray['result'] 			=  	[FALSE] if the query could not be executed
		 * 		@returns $returnArray['resultMessage'] 	=  	FAULT MESSAGE
		 * 		@returns $returnArray['rowcount'] 		=  	number of rows if the resultFormat is a list
		 *
		 */
		global $db;

		$returnArray								= array();
		$returnArray['result']					= false;
		$returnArray['rowcount']				= 0;

		try 
		{
			$tableQuery 			= $requestArray['query'];
			$selectQuery			= $db->Execute($tableQuery);
			
			$recordCount		= 0;
			while (!$selectQuery->EOF)
				{
					for ($i=0; $i < $selectQuery->FieldCount(); $i++)
						$returnArray[$recordCount]['field'.$i] = $selectQuery->fields[$i];
					$recordCount ++;	
					$selectQuery->MoveNext();
				}
			$returnArray['rowcount']				= $recordCount;
		} 
		catch (exception $e) 
		{
			$returnArray['resultMessage']	= $e;
		}		
		return $returnArray;
	}
}

?>