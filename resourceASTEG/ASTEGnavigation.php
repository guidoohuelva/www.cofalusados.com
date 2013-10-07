<?php
//---- NAVIGATION CHECK
    //--- CHECK TESTSERVER
    $deploy		= ( ($_SERVER['HTTP_HOST'] == '192.168.1.200') || ($_SERVER['HTTP_HOST'] == 'localhost') )?true:false;
    //--- CHECK IF WWW
    $www_position	= strpos($_SERVER['HTTP_HOST'], 'www.');
    //---- REDIRECT IF NOT TESTSERVER AND NOT WWW.
    if ( ($www_position === false) && ($deploy == false) )
            header( 'Location: http://www.'.$_SERVER['HTTP_HOST']);
?>