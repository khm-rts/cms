/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	
	// Standard version af CKeditor, tilpasset med følgende plugins ved download:
	// Auto Grow, Color Button ('TextColor','BGColor'), Color Dialog, Content Templates ('Templates'), Div Container Manager ('CreateDiv'), Find / Replace ('Find','Replace'), Font Awesome ('FontAwesome'), Font Size and Family ('Font','FontSize'), IFrame Dialog ('Iframe'), Insert Smiley ('Smiley'), Justify ('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'), Keep TextSelection, New Page ('NewPage'), Quicktable, Select All ('SelectAll'), Show Blocks ('ShowBlocks'), YouTube Plugin ('Youtube')

	config.skin	= 'minimalist';

	// Ekstra Plugins: Abbreviation Plugin (manuelt opdateret med dansk) 
	config.extraPlugins = 'abbr';
	
	// CKeditor
	config.filebrowserBrowseUrl			= '../assets/kcfinder-3.12/browse.php?opener=ckeditor&type=files';
	config.filebrowserImageBrowseUrl	= '../assets/kcfinder-3.12/browse.php?opener=ckeditor&type=images';
	config.filebrowserFlashBrowseUrl	= '../assets/kcfinder-3.12/browse.php?opener=ckeditor&type=flash';
	config.filebrowserUploadUrl			= '../assets/kcfinder-3.12/upload.php?opener=ckeditor&type=files';
	config.filebrowserImageUploadUrl	= '../assets/kcfinder-3.12/upload.php?opener=ckeditor&type=images';
	config.filebrowserFlashUploadUrl	= '../assets/kcfinder-3.12/upload.php?opener=ckeditor&type=flash';

	// The toolbar groups arrangement, optimized for two toolbar rows.
	/*config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];*/
	
	config.toolbar_Full =
	[	
		{ name: 'tools', items : [ 'ShowBlocks' ] },
		{ name: 'document', items : [ 'Source','-','NewPage','-','Templates' ] },
		{ name: 'clipboard', items : [ 'Undo','Redo' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		/*'/',*/
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert', items : [ 'Image','Table','CreateDiv','HorizontalRule','SpecialChar','Abbr','Iframe','Chart','Smiley','FontAwesome','Youtube' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote',
		'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] }
	];
	 
	config.toolbar_Basic =
	[
		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'Styles']
	];
	
	config.toolbar = 'Full';

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	// config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';
	
	// Allow all content like div with styles
	config.allowedContent=true;

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;image:Upload;link:advanced;link:upload';
	
	// Default skin: 'bootstrapck'
	// config.skin = 'moono';
	// config.skin = 'moono-dark';
	
	config.contentsCss = ['../assets/bootstrap-3.3.7/css/bootstrap.min.css', '../css/ckeditor.css', '../assets/font-awesome-4.6.3/css/font-awesome.min.css'];
	
	// Bootstraps bodyClass så body har en responsive bredde
	config.bodyClass = 'container';
	
	config.qtRows				= 8; // Count of rows in the quicktable (default: 8)
	config.qtColumns			= 8; // Count of columns in the quicktable (default: 10)
	config.qtBorder				= '0'; // Border of the inserted table (default: '1')
	config.qtWidth				= '100%'; // Width of the inserted table (default: '500px')
	config.qtStyle				= null, // Content of the style-attribute of the inserted table (default: null, example: { 'border-collapse' : 'collapse' })
	config.qtClass				= 'table'; // Class of the inserted table (default: '')
	config.qtCellPadding		= '0'; // Cell padding of the inserted table (default: '1')
	config.qtCellSpacing		= '0'; // Cell spacing of the inserted table (default: '1')
/*	config.qtPreviewBorder		= '4px double black'; // Border of the preview table (default: '1px solid #aaa')
	config.qtPreviewSize		= '4px'; // Cell size of the preview table (default: '14px')
	config.qtPreviewBackground	= '#c8def4'; // Cell background of the preview table on hover (default: '#e5e5e5')*/
};

CKEDITOR.on('dialogDefinition', function( ev ) {
	var diagName = ev.data.name;
	var diagDefn = ev.data.definition;
	if(diagName === 'table') {
		var infoTab = diagDefn.getContents('info');
		var width = infoTab.get('txtWidth');
		width['default'] = "100%";
		txtCellPad = infoTab.get( 'txtCellPad' );
		txtCellPad['default'] = "0";
		txtCellSpace = infoTab.get( 'txtCellSpace' );
		txtCellSpace['default'] = "0";
		txtBorder = infoTab.get( 'txtBorder' );
		txtBorder['default'] = "0";
	}
});