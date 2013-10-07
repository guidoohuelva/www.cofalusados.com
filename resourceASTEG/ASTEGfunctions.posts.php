<?php

class ASTEG_posts
{
	public function __construnct()
	{
	}

//---- PUBLIC FUNCTIONS

/**
* returns the selected posts, as a string HTML formated ready to print.
* posts_display formats via $post_format the way certain posts are to be displayed.
* @param int $post_groupID value to search posts via groupID
* @param int $post_count the post count to be displayed
*/
	static public function get_posts($post_groupID=-1,$post_count=1)
	{
		$ASTEGDB		= new ASTEG_database();
		$request_array	= array();
		$result_array		= array();
		$title_array		= array();
		$content_array	= array();

		$request_array['query']		= "SELECT *  FROM FRAMEWORK_POSTS WHERE POST_GROUPID = ".$post_groupID." ORDER BY DATE_MODIFIED LIMIT ".$post_count;
		$result_array 					= $ASTEGDB->database_advanced_query($request_array);
		for ($i =0; $i < $result_array[rowcount];$i++)
		{
			array_push($title_array,$result_array[$i][field1]);
			array_push($content_array,$result_array[$i][field2]);
		}

		$result 			= array("titles"=>$title_array, "content"=>$content_array);
		return $result;
	}

	static public function get_singlepost($post_groupID=-1)
	{
		$ASTEGDB		= new ASTEG_database();
		$request_array	= array();
		$result_array		= array();
		$title_array		= array();
		$content_array	= array();

		$request_array['query']		= "SELECT *  FROM FRAMEWORK_POSTS WHERE POST_GROUPID = ".$post_groupID." ORDER BY DATE_MODIFIED LIMIT 1";
		$result_array 					= $ASTEGDB->database_advanced_query($request_array);
		$result 								= $result_array[0][field2];
		return $result;
	}

}

?>