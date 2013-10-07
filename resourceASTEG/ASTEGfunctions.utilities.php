<?php
class ASTEG_utilities
{
	//---- CONSTRUCTOR
	public function __construct()
	{
	}
//---- BRANDING FUNCTIONS
	static public function utilities_display_companies()
	{
			//---- RANDOMIZE COMPANIES STRING
		$random_integer 	= rand(1,2);
		$company_one		= "ASTEGconsultores";
		$company_two		= "Perinola S.A.";
		if ($random_integer == 1)
			$companies = $company_one." &amp; ".$company_two;
		else
			$companies = $company_two." &amp; ".$company_one;
		return $companies;
	}
//---- DEBUG UTILITIES
	static public function debug()
	{
		echo '<div id="ASTEGdebug" style="border:1px solid #313131; background-color:#EEE; padding:10px 20px 20px 10px; font-size:12px; font-family:Helvetica,Tahoma,san-serif;">';
		echo "<h1 style='font-size:16px; color:#313131;text-align:center'>DEBUG Console</h1>";
		echo "<h2 style='font-size:12px; color:#313131;text-align:center'>".$_SESSION['FRAMEWORK_VERSION']."</h2>";
		echo "<label style='width=100%; text-align:center;font-size:10px;font-weight:bold;'>SESSION</label><br /><code>";
		print_r($_SESSION);
		echo "</code><br /><br /><label style='width=100%; text-align:center;font-size:10px;font-weight:bold;'>REQUEST</label><br /><code>";
		print_r($_REQUEST);
		echo "</code><br /><br /><label style='width=100%; text-align:center;font-size:10px;font-weight:bold;'>POST</label><br /><code>";
		print_r($_POST);
		echo "</code><br /><br /><label style='width=100%; text-align:center;font-size:10px;font-weight:bold;'>GET</label><br /><code>";
		print_r($_GET);
		echo "</code><br /><br /><label style='width=100%; text-align:center;font-size:10px;font-weight:bold;'>SERVER</label><br /><code>";
		print_r($_SERVER);
		echo '</code></div>';
	}

	static public function debug_array($current_array)
	{
		print "<pre>";
		print_r($current_array);
		print "<pre>";
	}
//---- NETWORK FUNCTIONS
	static public function utilities_ipaddress()
	{
		$result = "0:0:0:0";
    		if (!empty($_SERVER['HTTP_CLIENT_IP']))
    			$result 	= $_SERVER['HTTP_CLIENT_IP'];
    		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			$result	= $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else
	      	$result 	= $_SERVER['REMOTE_ADDR'];
		return $result;
	}

//---- DATE FUNCTIONS
	static public function utilities_timestamp()
	{
		$currentdate		= getdate();
		return $currentdate[0];
	}
	static public function utilities_mysql_date()
	{
		$currentdate		= getdate();
		return ($currentdate[year]."-".$currentdate[mon]."-".$currentdate[mday]);
	}
	static public function utilities_mysql_datetime()
	{
		$currentdate		= getdate();
		return ($currentdate[year]."-".$currentdate[mon]."-".$currentdate[mday]." ".$currentdate[hours].":".$currentdate[minutes].":".$currentdate[seconds]);
	}
	static public function utilities_get_current_year()
	{
		$currentdate		= getdate();
		return $currentdate[year];
	}
	static public function utilities_get_current_month()
	{
		$currentdate		= getdate();
		return $currentdate[mon];
	}
	static public function utilities_get_current_date()
	{
		$currentdate		= getdate();
		return $currentdate[mday];
	}
	static public function utilities_padded_date_array($date_array)
	{
		$return_array							= array();
		$return_array['day']				= str_pad($date_array[mday],2,"0",STR_PAD_LEFT);
		$return_array['month'] 			= str_pad($date_array[mon],2,"0",STR_PAD_LEFT);
		$return_array['year']				= str_pad($date_array[year],4,"0",STR_PAD_LEFT);
		return $return_array;
	}
	static public function utilities_padded_date($date_array)
	{
		$return_array	= ASTEG_utilities::utilities_padded_date_array($date_array);
		return $return_array['day']."/".$return_array['month']."/".$return_array['year'];
	}
	static public function utilities_mysql_to_dmy($date_mysql)
	{
		$datetime_array	= explode(" ", $date_mysql);
		$date_array				= explode("-", $datetime_array[0]);
		return $date_array[2]."/".$date_array[1]."/".$date_array[0];
	}
//---- STRING FUNCTIONS
	static public function utilities_cropstring($string,$count)
	{
		if ( strlen($string) <= $count )
		   return $string;
		else
		{
			// find the longest possible match
			$pos = 0;
			foreach ( array('. ', '? ', '! ') as $punct )
			{
		   		$npos = strpos($string, $punct);
		   		if ( $npos > $pos && $npos < $count )
				{
		       		$pos = $npos;
		   		}
			}

			if ($pos < $count-20 )
			{
		   		return substr($string, 0, $count-23) . '...';
			}
			if ( !$pos )
			{
		   		// substr $len-3, because the ellipsis adds 3 chars
		   		return substr($string, 0, $count-3) . '...';
			}
			else
			{
		   		// $pos+1 to grab punctuation mark
		   		return substr($string, 0, $pos+1);
			}
		}
	}
	static public function generate_string($length = 8)
	{
		// start with a blank password
		$password = "";
		// define possible characters
		$possible = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		// set up a counter
		$i = 0;
		// add random characters to $password until $length is reached
		while ($i < $length)
		{
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

			// we don't want this character if it's already in the password
			if (!strstr($password, $char))
			{
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}
	static public function validate_email($email)
	{
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	static public function pad_number($number,$n)
	{
		return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
	}
	public static function utilities_upload_image($upload_image_array,$image_path,$saved_filename = "")
	{
		$result				= "";
		//---- GET SOURCE FILE FROM $_FILE
		if ($upload_image_array[error] == 0)
		{
			//---- FILENAME SETUP
			$unique_filename		= uniqid("AST_");
			$extension_array 		= explode(".", $upload_image_array[name]);
			$extension_array 		= array_reverse($extension_array);
			$filename_extension		= ".".strtolower($extension_array[0]);
			$temporal_filename		= $upload_image_array[tmp_name];
			$destination_file		= ($saved_filename == "")?$unique_filename.$filename_extension:$saved_filename;
			move_uploaded_file($temporal_filename, $image_path.$destination_file);
			$result					= $destination_file;
		}
		return $result;
	}

}
?>