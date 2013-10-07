<?php
class ASTEG_resource
{
	//---- CONSTRUCTOR
	public function __construct()
	{
	}
//----- PUBLIC FUNCTIONS
	static public function resource_get($resource_label)
	{
		return ASTEG_resource::private_resource_get($resource_label);
	}

	static public function flat_table_decode($table_string)
	{
		$return_array					= array();
		$record_titles 					= array();
		$record_items 				= array();
		$explode_titles				= explode("||", $table_string);
		for ($i=1;$i < count($explode_titles);$i++)
		{
			if (strrpos($explode_titles[$i], "::") < -1)
				array_push($record_titles, $explode_titles[$i]);
			else
			{
				$explode_items = explode("::", $explode_titles[$i]);
				array_push($record_items,$explode_items);
			}
		}
		for ($i=0;$i <= count($record_titles); $i++)
		{
			$return_array[$record_titles[$i]] 	= $record_items[$i];
		}
		return $return_array;
	}

	static public function flat_table_encode($table_array)
	{
		foreach ($table_array as $table_key => $table_value)
			if ($table_key != "rowcount")
			{
				if (!empty($table_key))
					$return_string .= "||".$table_key."||";
				if (is_array($table_value))
					foreach ($table_value as $table_value_item)
						if (!empty($table_value_item))
							if (($table_value_item != "Array"))
								$return_string .= "::".$table_value_item;
				else
					$return_string .= "::".$table_value;
			}
		return $return_string;
	}
//----- PRIVATE FUNCTIONS

	static private function private_resource_get($resource_label)
	{
		$result 											= "";
		$ASTEGdb									= new ASTEG_database();
		$requestArray								= array();
		$requestArray['FIELDNAME']		= "RESOURCE_LABEL";
		$requestArray['FIELDCRITERIA']	= $resource_label;
		$resultArray 									= $ASTEGdb->database_read("FRAMEWORK_RESOURCE", $requestArray);
		$result 											= $resultArray['field2'];
		return $result;
	}

}
?>