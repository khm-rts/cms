/**
 * Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

// This file contains style definitions that can be used by CKEditor plugins.
//
// The most common use for it is the "stylescombo" plugin, which shows a combo
// in the editor toolbar, containing all styles. Other plugins instead, like
// the div plugin, use a subset of the styles on their feature.
//
// If you don't have plugins that depend on this file, you can simply ignore it.
// Otherwise it is strongly recommended to customize this file to match your
// website requirements and design properly.

CKEDITOR.stylesSet.add( 'default', [
	/* Block Styles */

	// These styles are already available in the "Format" combo ("format" plugin),
	// so they are not needed here by default. You may enable them to avoid
	// placing the "Format" combo in the toolbar, maintaining the same features.
	/*
	{ name: 'Paragraph',		element: 'p' },
	{ name: 'Heading 1',		element: 'h1' },
	{ name: 'Heading 2',		element: 'h2' },
	{ name: 'Heading 3',		element: 'h3' },
	{ name: 'Heading 4',		element: 'h4' },
	{ name: 'Heading 5',		element: 'h5' },
	{ name: 'Heading 6',		element: 'h6' },
	{ name: 'Preformatted Text',element: 'pre' },
	{ name: 'Address',			element: 'address' },
	*/

	{ name: 'Placer til venstre',	element: 'div', attributes: { 'class': 'pull-left' } }, // Float: Left
	{ name: 'Placer til højre',		element: 'div', attributes: { 'class': 'pull-right' } }, // Float: Right
	{ name: 'Fremhæv afsnit',	element: 'p', attributes: { 'class': 'lead' } },
	{ name: 'Række',			element: 'div', attributes: { 'class': 'row' } },
	{ name: 'Kolonne: 75%',		element: 'div', attributes: { 'class': 'col-md-9' } },
	{ name: 'Kolonne: 66%',		element: 'div', attributes: { 'class': 'col-md-8' } },
	{ name: 'Kolonne: 50%',		element: 'div', attributes: { 'class': 'col-md-6' } },
	{ name: 'Kolonne: 33%',		element: 'div', attributes: { 'class': 'col-md-4' } },
	{ name: 'Kolonne: 25%',		element: 'div', attributes: { 'class': 'col-md-3' } },
	{ name: 'Skjul på mobil',	element: 'div', attributes: { 'class': 'hidden-xs' } },
	{ name: 'Vis kun på mobil',	element: 'div', attributes: { 'class': 'visible-xs' } },
	{ name: 'IFrame: 16:9',		element: 'div', attributes: { 'class': 'embed-responsive embed-responsive-16by9' } },
	{ name: 'IFrame: 4:3',		element: 'div', attributes: { 'class': 'embed-responsive embed-responsive-4by3' } },
	{ name: 'Meddelelse',		element: 'div', attributes: { 'class': 'alert alert-success' } },
	{ name: 'Meddelelse',		element: 'div', attributes: { 'class': 'alert alert-info' } },
	{ name: 'Meddelelse',		element: 'div', attributes: { 'class': 'alert alert-warning' } },
	{ name: 'Meddelelse',		element: 'div', attributes: { 'class': 'alert alert-danger' } },
	

	/* Inline Styles */

	// These are core styles available as toolbar buttons. You may opt enabling
	// some of them in the Styles combo, removing them from the toolbar.
	// (This requires the "stylescombo" plugin)
	/*
	{ name: 'Strong',			element: 'strong', overrides: 'b' },
	{ name: 'Emphasis',			element: 'em'	, overrides: 'i' },
	{ name: 'Underline',		element: 'u' },
	{ name: 'Strikethrough',	element: 'strike' },
	{ name: 'Subscript',		element: 'sub' },
	{ name: 'Superscript',		element: 'sup' },
	*/

	{ name: 'Lille',			element: 'small' }, // Small

	{ name: 'Computer kode',	element: 'code' }, // Computer code
	{ name: 'Tastekombination',	element: 'kbd' }, // Keyboard Phrase
	{ name: 'Eksempeltekst',	element: 'samp' }, // Sample Text
	{ name: 'Variabel',			element: 'var' },

	{ name: 'Slettet tekst',	element: 'del' }, // Deleted Text
	{ name: 'Tilføjet tekst',	element: 'ins' }, // Inserted Text

	{ name: 'Citeret arbejde',	element: 'cite' }, // Cited Work
	{ name: 'Citeret',			element: 'q' }, // Inline Quotation
	
	{ name: 'Markeret',			element: 'mark', attributes: {} },
	{ name: 'Tekstfarve',		element: 'span', attributes: { 'class': 'text-muted' } },
	{ name: 'Tekstfarve',		element: 'span', attributes: { 'class': 'text-primary' } },
	{ name: 'Tekstfarve',		element: 'span', attributes: { 'class': 'text-success' } },
	{ name: 'Tekstfarve',		element: 'span', attributes: { 'class': 'text-info' } },
	{ name: 'Tekstfarve',		element: 'span', attributes: { 'class': 'text-warning' } },
	{ name: 'Tekstfarve',		element: 'span', attributes: { 'class': 'text-danger' } },
	{ name: 'Baggrundsfarve',	element: 'span', attributes: { 'class': 'bg-primary' } },
	{ name: 'Baggrundsfarve',	element: 'span', attributes: { 'class': 'bg-success' } },
	{ name: 'Baggrundsfarve',	element: 'span', attributes: { 'class': 'bg-info' } },
	{ name: 'Baggrundsfarve',	element: 'span', attributes: { 'class': 'bg-warning' } },
	{ name: 'Baggrundsfarve',	element: 'span', attributes: { 'class': 'bg-danger' } },
	{ name: 'Label',			element: 'span', attributes: { 'class': 'label label-default' } },
	{ name: 'Label',			element: 'span', attributes: { 'class': 'label label-primary' } },
	{ name: 'Label',			element: 'span', attributes: { 'class': 'label label-success' } },
	{ name: 'Label',			element: 'span', attributes: { 'class': 'label label-info' } },
	{ name: 'Label',			element: 'span', attributes: { 'class': 'label label-warning' } },
	{ name: 'Label',			element: 'span', attributes: { 'class': 'label label-danger' } },
	{ name: 'Skilt',			element: 'span', attributes: { 'class': 'badge' } },

	/* Object Styles */

	{ name: 'Swipebox',			element: 'a', attributes: { 'class': 'swipebox' } },

	{
		name: 'Venstrestillet',
		element: 'img',
		attributes: { 'class': 'pull-left img-responsive' }
	},

	{
		name: 'Centreret',
		element: 'img',
		attributes: { 'class': 'center-block img-responsive' }
	},

	{
		name: 'Højrestillet',
		element: 'img',
		attributes: { 'class': 'pull-right img-responsive' }
	},

	{
		name: 'Thumbnail (miniature)',
		element: 'img',
		attributes: { 'class': 'img-thumbnail img-responsive' }
	},

	{
		name: 'Afrundet',
		element: 'img',
		attributes: { 'class': 'img-rounded img-responsive' }
	},

	{
		name: 'Cirkel',
		element: 'img',
		attributes: { 'class': 'img-circle img-responsive' }
	},

	{
		name: 'Tabel: Standard',
		element: 'table',
		attributes: { 'class': 'table', 'border': '0', 'cellpadding': '0', 'cellspacing': '0', 'style': '' }
	},

	{
		name: 'Tabel: Kompakt',
		element: 'table',
		attributes: { 'class': 'table table-condensed', 'border': '0', 'cellpadding': '0', 'cellspacing': '0', 'style': '' }
	},

	{
		name: 'Tabel: Stribede rækker',
		element: 'table',
		attributes: { 'class': 'table table-striped', 'border': '0', 'cellpadding': '0', 'cellspacing': '0', 'style': '' }
	},

	{
		name: 'Tabel: Med rammer',
		element: 'table',
		attributes: { 'class': 'table table-bordered', 'border': '0', 'cellpadding': '0', 'cellspacing': '0', 'style': '' }
	},

	{
		name: 'Table: Hover rækker',
		element: 'table',
		attributes: { 'class': 'table table-hover', 'border': '0', 'cellpadding': '0', 'cellspacing': '0', 'style': '' }
	},

	{ name: 'Række: Aktiv',		element: 'tr', attributes: { 'class': 'active' } },
	{ name: 'Række: Succes',	element: 'tr', attributes: { 'class': 'success' } },
	{ name: 'Række: Advarsel',	element: 'tr', attributes: { 'class': 'warning' } },
	{ name: 'Række: Fare',		element: 'tr', attributes: { 'class': 'danger' } },
	{ name: 'Række: Info',		element: 'tr', attributes: { 'class': 'info' } },

	{ name: 'Celle: Aktiv',		element: 'td', attributes: { 'class': 'active' } },
	{ name: 'Celle: Succes',	element: 'td', attributes: { 'class': 'success' } },
	{ name: 'Celle: Advarsel',	element: 'td', attributes: { 'class': 'warning' } },
	{ name: 'Celle: Fare',		element: 'td', attributes: { 'class': 'danger' } },
	{ name: 'Celle: Info',		element: 'td', attributes: { 'class': 'info' } },
	
	
	{ name: 'Højrestil blokcitat',	element: 'blockquote', attributes: { 'class': 'blockquote-reverse' } },
	
	
	{ name: 'Square Bulleted List',	element: 'ul',		styles: { 'list-style-type': 'square' } }
] );

