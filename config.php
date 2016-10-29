<?php
session_start();

$root			= '';
$include_path	= 'includes/';
define('DEVELOPER_STATUS',	true);

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

require 'includes/functions.php';

// If user is logged in, use functions to match fingerprint and last activity and log the user out if one of them return false
if ( isset($_SESSION['user']['id']) )
{
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
if ( $mysqli->connect_error ) connect_error(__LINE__, __FILE__);

// Set charset from Db text to utf8
$mysqli->set_charset('utf8');

// Set the database server to danish names for date and times
$result = $mysqli->query("SET lc_time_names = 'da_DK';");

// If result returns false, use the function query_error to show debugging info
if (!$result) query_error($query, __LINE__, __FILE__);
