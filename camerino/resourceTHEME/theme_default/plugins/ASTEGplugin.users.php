<?php
class ASTEGplugin_users
{
	var $plugin_table;
	var $plugin_user_ID;
	var $user_array;

	//---- CONSTRUCTOR
	public function __construct()
	{
		//---- SETTINGS
		$this->plugin_table							= "FRAMEWORK_USERS";
		$this->plugin_user_ID							= $_SESSION['ASTEGFRAMEWORK_USER_ID']; //---- @TODO: Evalute SAFETY HERE
		if (isset($this->plugin_user_ID))
		{
			//----- GET USER ARRAY
			$ASTEGdb					= new ASTEG_database();
			$request_array			= array();
			$result_array				= array();
			$request_array['ID']	= $this->plugin_user_ID;
			$this->user_array		= $ASTEGdb->database_read($this->plugin_table,$request_array);
		}
	}

	public function users_get_registrationdate()
	{
		return $this->user_array['field7'];
	}
	public function users_get_website()
	{
		return $this->user_array['field16'];
	}
	public function users_get_expirationdate()
	{
		return $this->user_array['field15'];
	}
	public function users_get_database_spec()
	{
		$database_array						= array();
		$database_array['dbname']	= $this->user_array['field8'];
		$database_array['dbhost']		= $this->user_array['field9'];
		$database_array['dbuser']		= $this->user_array['field10'];
		$database_array['dbpass']	= $this->user_array['field11'];

		return $database_array;
	}
	public function users_get_analytics_ID()
	{
		return $this->user_array['field12'];
	}
	public function users_get_twitter_ID()
	{
		return $this->user_array['field13'];
	}
	public function users_get_bulletinboard()
	{
		return $this->user_array['field14'];
	}
	public function users_daysleft()
	{
		$expiration_date				= $this->users_get_expirationdate();
		$ASTEGdb							= new ASTEG_database();
		$request_array					= array();
		$result_array						= array();
		$request_array['query']	= "SELECT DATEDIFF('".$expiration_date."',CURRENT_DATE())";
		$result_array						= $ASTEGdb->database_advanced_query($request_array);
		return $result_array[0]['field0'];
	}




}
?>