<?php
	class ASTEG_content
	{
		public function __constructor()
		{
		}
		
		
		public function content_page_access_level($ID)
		{
			return ASTEG_content::content_private_page_access_level($ID);
		}
		
		
//---- TO BE REWRITTEN
		
		public function content_path($ID)
		{
			$file_path								= "";
			
			$ASTEGdb							= new ASTEG_database();
			$requestArray						= array();
			$requestArray['FIELDNAME']		= "ID";
			$requestArray['FIELDCRITERIA']	= $ID;
			$resultArray 							= $ASTEGdb->database_read("CAMERINO_PAGES", $requestArray);
			if ($resultArray['result'] == true)
			{
				$file_path		= $resultArray['field2'];
			}
			else
			{
				$file_path 	= "404.php";
			}
			return $file_path;
		}

		public function content_website_title($ID)
		{
			$result 								= "";
			$ASTEGdb							= new ASTEG_database();
			$requestArray						= array();
			$requestArray['FIELDNAME']		= "ID";
			$requestArray['FIELDCRITERIA']	= $ID;
			$resultArray 							= $ASTEGdb->database_read("CAMERINO_PAGES", $requestArray);
			if ($resultArray['result'] == true)
				$result	= $resultArray['field1'];
			
			return $result; 
		}

		public function content_message_queue_display()
		{
			$theme_path	= ASTEG_resource::resource_get("RESOURCE_THEME_URL");
			include_once($theme_path."messages.php");
			$requestQueue	= $_SESSION['ASTEGFRAMEWORK_MESSAGE_QUEUE'];
			if (!empty($requestQueue))
				$resultArray		= explode("||", $requestQueue);
			unset($_SESSION['ASTEGFRAMEWORK_MESSAGE_QUEUE']);
			for ($i = 0; $i < count($resultArray) - 1; $i++)
			{
				echo '<div class="framework_warning">';
				echo $ASTEG_MESSAGE_ARRAY[$resultArray[$i]];
				echo '</div>';
			}
			
		}

		public function content_message_queue_add($queue_element="")
		{
			$_SESSION['ASTEGFRAMEWORK_MESSAGE_QUEUE'] .= $queue_element."||";	
		}

//---- PRIVATE FUNCTIONS
		private function content_private_page_access_level($ID)
		{
			//---- RETURNS THE ACCESS LEVEL FOR A PAGE
			$result = 0;
			$ASTEGdb							= new ASTEG_database();
			$requestArray						= array();
			$requestArray['ID']					= $ID;
			$resultArray 							= $ASTEGdb->database_read("CAMERINO_PAGES", $requestArray);
			if ($resultArray['result'] == true)
				$result 		= $resultArray['field7']; 
			
			return $result;
		}

	}
?>