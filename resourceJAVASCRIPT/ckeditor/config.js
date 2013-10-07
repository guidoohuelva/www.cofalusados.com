/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.uiColor = '#AADC6E';
	config.language 								= 'en';
	var $KCbrowser_path						= '../resourcePLUGINS/kcfinder/';
	config.filebrowserBrowseUrl 			= $KCbrowser_path+'browse.php?type=files';
	config.filebrowserImageBrowseUrl 	= $KCbrowser_path+'browse.php?type=images';
	config.filebrowserFlashBrowseUrl 		= $KCbrowser_path+'browse.php?type=flash';
	config.filebrowserUploadUrl 				= $KCbrowser_path+'upload.php?type=files';
	config.filebrowserImageUploadUrl 		= $KCbrowser_path+'/upload.php?type=images';
	config.filebrowserFlashUploadUrl 		= $KCbrowser_path+'/upload.php?type=flash';

	config.toolbar = 'ASTEGtoolbar';
    config.toolbar_ASTEGtoolbar =
	[
	    ['Styles','Format','Font','FontSize','-','Preview','-','Templates'],
	    ['Cut','Copy','Paste','PasteText','PasteFromWord','Image'],
	    ['Undo','Redo'],['Find','Replace'],['SelectAll','RemoveFormat'],
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['Link','Unlink'],
	    ['TextColor','BGColor','-','Maximize', 'ShowBlocks','Source']
	];

};
