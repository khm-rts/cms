<?php
session_start();

$root			= '';
$include_path	= 'includes/';
define('DEVELOPER_STATUS',	true);
define('PAGE_LENGTH', 		10);

// If developer status is true / enabled
if (DEVELOPER_STATUS)
{
	// Set error_reporting to E_ALL (default on XAMPP), which display all errors
	error_reporting(E_ALL);
}
else
{
	// Turn off all error reporting (default on most servers)
	error_reporting(0);
}

require 'lang/da_DK.php';
require $include_path . 'functions.php';

if ( isset($_SESSION['user']['id']) )
{
	// If page isn't reloaded, the securty functions wasn't run on index.php, so run them here
	check_fingerprint();
	check_last_activity();
}

// Configuration for Database
$db_host	= 'localhost';
$db_user	= 'root';
$db_pass	= '';
$db_name	= 'cmk_cms';

// Connect to database
$mysqli		= new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check for connection error
if ( $mysqli->connect_error )
{
	connect_error($mysqli->connect_errno, $mysqli->connect_error, __LINE__, __FILE__);
}
// Set charset from Db text to utf8
$mysqli->set_charset('utf8');

// Set the database server to danish names for date and times
$mysqli->query("SET lc_time_names = 'da_DK';");

// Array with icons used in CMS
$icons =
[
	'caret-down'	=> '<i class="fa fa-caret-down fa-fw" aria-hidden="true"></i>',
	'check'			=> '<i class="fa fa-check fa-fw" aria-hidden="true"></i>',
	'create'		=> '<i class="fa fa-plus fa-fw" aria-hidden="true"></i>',
	'edit'			=> '<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>',
	'external-link'	=> '<i class="fa fa-external-link fa-fw" aria-hidden="true"></i>',
	'delete'		=> '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>',
	'save'			=> '<i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i>',
	'search'		=> '<i class="fa fa-search fa-fw" aria-hidden="true"></i>',
	'preview'		=> '<i class="fa fa-eye fa-fw" aria-hidden="true"></i>',
	'times'			=> '<i class="fa fa-times fa-fw" aria-hidden="true"></i>',
	'dashboard'		=> '<i class="fa fa-dashboard fa-fw" aria-hidden="true"></i>',
	'warning'		=> '<i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i>',
	'users'			=> '<i class="fa fa fa-users fa-fw" aria-hidden="true"></i>',
	'files'			=> '<i class="fa fa-files-o fa-fw" aria-hidden="true"></i>',
	'file-text'		=> '<i class="fa fa-file-text-o fa-fw" aria-hidden="true"></i>',
	'puzzle'		=> '<i class="fa fa-puzzle-piece fa-fw" aria-hidden="true"></i>',
	'sitemap'		=> '<i class="fa fa-sitemap fa-fw" aria-hidden="true"></i>',
	'comment'		=> '<i class="fa fa-comment fa-fw" aria-hidden="true"></i>',
	'comments'		=> '<i class="fa fa-comments-o fa-fw" aria-hidden="true"></i>',
	'sign-in'		=> '<i class="fa fa-sign-in fa-fw" aria-hidden="true"></i>',
	'sign-out'		=> '<i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>',
	'sort'			=> '<i class="fa fa-sort fa-fw sortable-handle" aria-hidden="true"></i>',
	'sort-asc'		=> '<i class="fa fa-sort-amount-asc fa-fw" aria-hidden="true"></i>',
	'sort-desc'		=> '<i class="fa fa-sort-amount-desc fa-fw" aria-hidden="true"></i>',
	'user'			=> '<i class="fa fa-user fa-fw" aria-hidden="true"></i>',
	'previous'		=> '<i class="fa fa-angle-left fa-fw" aria-hidden="true"></i>',
	'next'			=> '<i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>',
	'history'		=> '<i class="fa fa-history fa-fw" aria-hidden="true"></i>',
	'settings'		=> '<i class="fa fa-cog fa-fw" aria-hidden="true"></i>',
	'link'			=> '<i class="fa fa-link fa-fw" aria-hidden="true"></i>'
];

// Array with buttons used in CMS
$buttons =
[
	'save'		=> 'btn btn-success',
	'create'	=> 'btn btn-success',
	'edit'		=> 'btn btn-warning btn-xs',
	'delete'	=> 'btn btn-danger btn-xs',
	'primary'	=> 'btn btn-primary',
	'default'	=> 'btn btn-default'
];

// Array with options for page length
$page_lengths =
[
	1	=> 1,
	2	=> 2,
	10	=> 10,
	25	=> 25,
	50	=> 50,
	100	=> 100
];

// Array with files for dynamic include (key: file names from view folder, value: Array with details to each file)
$view_files =
[
	'index'	=>
	[
		'icon'	=> $icons['dashboard'],
		'title' => DASHBOARD,
		'nav'	=> true,
		'required_access_lvl' => 10
	],

	'error' =>
	[
		'icon'	=> $icons['warning'],
		'title' => isset($_GET['status']) ? 'HTTP ' . $_GET['status'] : ERROR,
		'nav'	=> false,
		'required_access_lvl' => 10
	],

	'settings' =>
	[
		'icon'	=> $icons['settings'],
		'title'	=> SETTINGS,
		'nav'	=> true,
		'required_access_lvl' => 100
	],

	'users' =>
	[
		'icon'	=> $icons['users'],
		'title'	=> USERS,
		'nav'	=> true,
		'required_access_lvl' => 100
	],

	'user-create' =>
	[
		'icon'	=> $icons['users'],
		'title'	=> USERS,
		'nav'	=> false,
		'required_access_lvl' => 100
	],

	'user-edit' =>
	[
		'icon'	=> $icons['users'],
		'title'	=> USERS,
		'nav'	=> false,
		'required_access_lvl' => 100
	],

	'pages' =>
	[
		'icon'	=> $icons['files'],
		'title'	=> PAGES,
		'nav'	=> true,
		'required_access_lvl' => 100
	],

		'page-create' =>
		[
			'icon'	=> $icons['files'],
			'title'	=> PAGES,
			'nav'	=> false,
			'required_access_lvl' => 100
		],

		'page-edit' =>
		[
			'icon'	=> $icons['files'],
			'title'	=> PAGES,
			'nav'	=> false,
			'required_access_lvl' => 100
		],

		'page-content' =>
		[
			'icon'	=> $icons['file-text'],
			'title'	=> PAGE_CONTENT,
			'nav'	=> false,
			'required_access_lvl' => 100
		],

			'page-content-create' =>
			[
				'icon'	=> $icons['file-text'],
				'title'	=> PAGE_CONTENT,
				'nav'	=> false,
				'required_access_lvl' => 100
			],

			'page-content-edit' =>
			[
				'icon'	=> $icons['file-text'],
				'title'	=> PAGE_CONTENT,
				'nav'	=> false,
				'required_access_lvl' => 100
			],

	'page-functions' =>
	[
		'icon'	=> $icons['puzzle'],
		'title'	=> PAGE_FUNCTIONS,
		'nav'	=> true,
		'required_access_lvl' => 1000
	],

	'menus' =>
	[
		'icon'	=> $icons['sitemap'],
		'title'	=> MENUS,
		'nav'	=> true,
		'required_access_lvl' => 100
	],

		'menu-links' =>
		[
			'icon'	=> $icons['link'],
			'title'	=> LINKS,
			'nav'	=> false,
			'required_access_lvl' => 100
		],

			'menu-link-create' =>
			[
				'icon'	=> $icons['link'],
				'title'	=> LINKS,
				'nav'	=> false,
				'required_access_lvl' => 100
			],

			'menu-link-edit' =>
			[
				'icon'	=> $icons['link'],
				'title'	=> LINKS,
				'nav'	=> false,
				'required_access_lvl' => 100
			],

	'posts' =>
	[
		'icon'	=> $icons['comment'],
		'title'	=> BLOG_POSTS,
		'nav'	=> true,
		'required_access_lvl' => 10
	],

		'post-create' =>
		[
			'icon'	=> $icons['comment'],
			'title'	=> BLOG_POSTS,
			'nav'	=> false,
			'required_access_lvl' => 10
		],

		'post-edit' =>
		[
			'icon'	=> $icons['comment'],
			'title'	=> BLOG_POSTS,
			'nav'	=> false,
			'required_access_lvl' => 10
		],

		'comments' =>
		[
			'icon'	=> $icons['comments'],
			'title'	=> COMMENTS,
			'nav'	=> false,
			'required_access_lvl' => 10
		],

			'comment-create' =>
			[
				'icon'	=> $icons['comments'],
				'title'	=> COMMENTS,
				'nav'	=> false,
				'required_access_lvl' => 10
			],

			'comment-edit' =>
			[
				'icon'	=> $icons['comments'],
				'title'	=> COMMENTS,
				'nav'	=> false,
				'required_access_lvl' => 10
			],

	'events' =>
	[
		'icon'	=> $icons['history'],
		'title'	=> LOGBOOK,
		'nav'	=> true,
		'required_access_lvl' => 100
	]
];
