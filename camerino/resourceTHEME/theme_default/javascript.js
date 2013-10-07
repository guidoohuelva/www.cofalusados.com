$(document).ready( function()
{
	//---- VARIABLES
});

function display_post($current_ID)
{
	if ($("#display_item"+$current_ID).is(":visible") == false  )
	{
		$current_HTML		= xajax_posts_display($current_ID);
		$("#display_item"+$current_ID).html($current_HTML);
		$("#display_item"+$current_ID).fadeIn();
		$(".website_header_button").button();

	}
	else
	{
		$("#display_item"+$current_ID).html("");
		$("#display_item"+$current_ID).fadeOut();		
	}
}