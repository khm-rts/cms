<?php
/**
 * Function to display a bootstrap styled message
 * @param string $type:		Part of class name that defines the color of the box. success || warning || danger etc.
 * @param string $message:	The text to display inside the box
 */
function alert($type, $message)
{
	?>
	<div class="alert alert-<?php echo $type ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $message ?>
	</div>
	<?php
}

/**
 * Function to display debugging info when a connect to the database fails
 * @param int $line_number:		The current line number where the function is runned. Use magic constant __LINE__
 * @param string $file_name:	The current file where the function is runned. Use magic constant __FILE__
 */
function connect_error($line_number, $file_name)
{
	global $mysqli;

	// If developer status is set to true, show all information
	if (DEVELOPER_STATUS)
	{
		die('<p>Forbindelsesfejl (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error . '</p><p>Linje: ' . $line_number . '</p><p>Fil: ' . $file_name . '</p>');
	}
	// If developer status is set to false, only show user friendly message
	else
	{
		die(CONNECT_ERROR);
	}
}

/**
 * Function to display debugging info when a query to the database fails
 * @param string $query:		The query/sql that failed
 * @param int $line_number:		The current line number where the function is runned. Use magic constant __LINE__
 * @param string $file_name:	The current file where the function is runned. Use magic constant __FILE__
 */
function query_error($query, $line_number, $file_name)
{
	global $mysqli;

	// If developer status is set to true, show all information
	if (DEVELOPER_STATUS)
	{
		$message =
				'<strong>' . $mysqli->error . '</strong><br>
			Linje: <strong>' . $line_number .' </strong><br>
			Fil: <strong>' . $file_name . '</strong>
			<pre class="prettyprint lang-sql linenums"><code>' . $query . '</code></pre>';

		alert('danger', $message);
		$mysqli->close();
	}
	// If developer status is set to false, only show user friendly message
	else
	{
		alert('danger', 'Der skete en fejl, prøv venligst igen. Kontakt os hvis problemet fortsætter');
		$mysqli->close();

	}
}

/**
 * Function to display data in pre and code tag and styled with Googles Prettyprint
 * @param $data
 */
function prettyprint($data, $prefix_string = '')
{
	?>
	<pre class="prettyprint lang-php"><code><?php echo $prefix_string; print_r($data) ?></code></pre>
	<?php
}

/**
 * Function to show all the typically hidden information that is useful for developers
 */
function show_developer_info()
{
	// If developer status is set to true, show all information from get/post/files/session/cookie
	if (DEVELOPER_STATUS)
	{
		echo '<br>';
		prettyprint($_GET, 'GET ');
		prettyprint($_POST, 'POST ');
		prettyprint($_FILES, 'FILES ');
		prettyprint($_SESSION, 'SESSION ');
		prettyprint($_COOKIE, 'COOKIE ');
	}
}

/**
 * Function to create links for pagination
 * @param string $page: The name of the file in view/ the links in the pagination should refer to
 * @param int $page_no: current page no
 * @param int $items_total: the counted total amount of items
 * @param int $page_length: the desired amount of items per page
 * @param int $page_around: The desired amount of pages to show before and after the current page
 * @param bool $show_disabled_arrows: Show disabled next or previous links, or hide them
 */
function pagination($page, $page_no, $items_total, $page_length, $page_around = 2, $show_disabled_arrows = true)
{
	// Only show pagination total items is greater than page length
	if ($items_total > $page_length)
	{
		$pages_total = ceil($items_total / $page_length);

		// Page to start the for-loop from, at least 2 below (or what's set in page_around) the current page
		$page_from = $page_no - $page_around;

		// If current page (page_no) is in the last half of visible pages, set page_from to the total pages minus page_around x2 (default 2x2) plus 2. Default page_from will be calculated to 6 below the total amount
		if ($page_no > $pages_total - $page_around * 2) $page_from = $pages_total - ($page_around * 2 + 2);

		// If page_from was calculated to be below 2, we start from the lowest number 2 (because we always have page one)
		if ($page_from < 2) $page_from = 2;

		// Page to end the for-loop with, at least 2 above (or what's set in page_around) the current page
		$page_to = $page_no + $page_around;

		// If current page (page_no) is in the first half of visible pages, set page_to, to page_around x2 (default 2x2), plus 3. Default page_to, will be calcaluted to 7
		if ($page_no <= $page_around * 2) $page_to = $page_around * 2 + 3;

		// If page_to was calculated to be above or equal to the total amount of pages, we end with the highest number possible. One below the total number, because we always have the last page.
		if ($page_to >= $pages_total) $page_to = $pages_total - 1;

		echo '<ul class="pagination">';

		// If current page is greater than 1, show previous button
		if ($page_no > 1)
		{
			echo '<li><a href="index.php?page=' . $page . '&page-no=' . ($page_no - 1) . '" data-page="' . $page . '" data-params="page-no=' . ($page_no - 1) . '"><i class="fa fa-angle-left fa-fw" aria-hidden="true"></i></a></li>';
		}
		// If current page is not greater than 1 and show_disabled_arrows is set to true, show disabled previous link
		else if ($show_disabled_arrows)
		{
			echo '<li class="disabled"><span><i class="fa fa-angle-left fa-fw" aria-hidden="true"></i></span></li>';
		}

		// Show first page
		echo '<li' . ($page_no == 1 ? ' class="active"' : '') . '><a href="index.php?page=' . $page . '&page-no=1" data-page="' . $page . '" data-params="page-no=1">1</a></li>';

		// If page_from is greater than 2, we have skipped some pages, and show 3 dots
		if ($page_from > 2)
		{
			echo '<li class="disabled"><span>&hellip;</span></li>';
		}

		// Do for-loop, start from number in page_from, and end with the number in page_to, increment with one each time the loop runs
		for($i = $page_from; $i <= $page_to; $i++)
		{
			echo '<li' . ($page_no == $i ? ' class="active"' : '') . '><a href="index.php?page=' . $page . '&page-no=' . $i . '" data-page="' . $page . '" data-params="page-no=' . $i . '">' . $i . '</a></li>';
		}

		// If page_to is smaller than the second last page, we have skipped some pages in the end, so we show 3 dots
		if ($page_to < $pages_total - 1)
		{
			echo '<li class="disabled"><span>&hellip;</span></li>';
		}

		// Show last page
		echo '<li' . ($page_no == $pages_total ? ' class="active"' : '') . '><a href="index.php?page=' . $page . '&page-no=' . $pages_total . '" data-page="' . $page . '" data-params="page-no=' . $pages_total . '">' . $pages_total . '</a></li>';

		// If current page is smaller than pages total, show next link
		if ($page_no < $pages_total)
		{
			echo '<li><a href="index.php?page=' . $page . '&page-no=' . ($page_no + 1) . '" data-page="' . $page . '" data-params="page-no=' . ($page_no + 1) . '"><i class="fa fa-angle-right fa-fw" aria-hidden="true"></i></a></li>';
		}
		// If current page is not smaller than pages total and show_disabled_arrows is set to true, show disabled next link
		else if ($show_disabled_arrows)
		{
			echo '<li class="disabled"><span><i class="fa fa-angle-right fa-fw" aria-hidden="true"></i></span></li>';
		}

		echo '</ul>';
	}
}

/**
 * Function to get links from related menu
 * @param int $menu_id:			id for the related menu, links should be pulled from
 * @param string $page_url_key:	URL key for current page
 * @param string $post_url_key: URL key for current post
 */
function get_menu_links($menu_id, $page_url_key = '', $post_url_key = '')
{
	global $mysqli;

	// Get links to bookmarks and active pages/posts to the main menu from the database
	$query =
			"SELECT
				menu_link_name, menu_link_bookmark, menu_link_type_id, menu_link_type_prefix_url, page_url_key, post_url_key
			FROM
				menus_menu_links
			INNER JOIN
				menu_links ON menus_menu_links.fk_menu_link_id = menu_links.menu_link_id
			INNER JOIN
				menu_link_types ON menu_links.fk_link_type_id = menu_link_types.menu_link_type_id
			INNER JOIN
				pages ON menu_links.fk_page_id = pages.page_id
			LEFT JOIN
				posts ON menu_links.fk_post_id = posts.post_id
			WHERE
				fk_menu_id = $menu_id
			AND
				page_status = 1
			AND
				(post_status IS NULL
			OR
				post_status = 1)
			ORDER BY
				menu_link_order";
	$result = $mysqli->query($query);

	// If result returns false, use the function query_error to show debugging info
	if (!$result) query_error($query, __LINE__, __FILE__);

	while( $row = $result->fetch_object() )
	{
		$url = empty($row->page_url_key) ? './' : 'index.php?page=' . $row->page_url_key;

		switch ($row->menu_link_type_id)
		{
			// If link type is 3 (bookmark) append this to the $url
			case 3:
				// If the bookmark is on the current page, only use the bookmark in url, so clear value in $url
				if ($row->page_url_key == $page_url_key) $url = '';

				// If both prefix url and bookmark is defined, append the values to the variable $url
				$url .= isset($row->menu_link_type_prefix_url) && isset($row->menu_link_bookmark) ? $row->menu_link_type_prefix_url . $row->menu_link_bookmark : '';
				$active = '';
				break;
			// If link type is 2 (post) append this to the $url
			case 2:
				// If both prefix url and the url key for the post is defined, append the values to the variable $url
				$url .= isset($row->menu_link_type_prefix_url) && isset($row->post_url_key) ? $row->menu_link_type_prefix_url . $row->post_url_key : '';

				// If the current page and post mathes this link for the post, add the class active to the li that wraps the link
				$active = $row->page_url_key == $page_url_key && $row->post_url_key == $post_url_key ? ' class="active"' : '';
				break;
			default:
				// If the page_url_key matches the current page, add the class active to the li that wraps the link
				$active = $row->page_url_key == $page_url_key ? ' class="active"' : '';
			//$current_url = basename($_SERVER['REQUEST_URI']);
			//$active = $current_url == $url || ($page_url_key == '' && $row->page_url_key == '') ? ' class="active"' : '';
		}

		echo '<li' . $active . '><a href="' . $url . '">' . $row->menu_link_name . '</a></li>';
	}
}

/**
 * Take the user agent info from the browser, add a salt and hash the information with the algo sha256
 * @return string
 */
function fingerprint()
{
	return hash('sha256', $_SERVER['HTTP_USER_AGENT'] . '!Å%bpxP-ghQæØ#_(');
}

/**
 * Function to run on login
 * @param string $email: The typed e-mail address
 * @param string $password_ The typed password
 * @return bool
 */
function login($email, $password)
{
	// If one of the required fields is empty, show alert
	if ( empty($email) || empty($password) )
	{
		alert('warning', 'Ikke alle påkrævede felter er udfyldt!');
	}
	// If all required fields is not empty, continue
	else
	{
		global $mysqli;

		$email	= $mysqli->escape_string($email);

		// Select active user that matches the typed e-mail address
		$query	=
			"SELECT 
				user_id, user_name, user_password, role_access_level
			FROM 
				users
			INNER JOIN 
				roles ON users.fk_role_id = roles.role_id
			WHERE 
				user_email = '$email' 
			AND 
				user_status = 1";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result)
		{
			query_error($query, __LINE__, __FILE__);
		}

		// If a user with the typed email was found in the database, do this
		if ( $result->num_rows == 1 )
		{
			$row = $result->fetch_object();

			// Check if the typed password matched the hashed password in the Database
			if ( password_verify($password, $row->user_password) )
			{
				// Give the current session a new id before saving user information into it
				session_regenerate_id();

				$_SESSION['user']['id']				= $row->user_id;
				$_SESSION['user']['access_level']	= $row->role_access_level;
				$_SESSION['fingerprint'] 			= fingerprint();

				return true;
			}
			// If the typed password didn't match the hashed password in the Database
			else
			{
				alert('warning', 'Den indtastede e-mailadresse og/eller adgangskode er ikke korrekt');
			}
		}
		// If no user with the typed email was found in the database, show this alert
		else
		{
			alert('warning', 'Den indtastede e-mailadresse og/eller adgangskode er ikke korrekt');
		}
	}
	return false;
}

/**
 * Delete the sessions from login and give the session a new id
 */
function logout()
{
	unset($_SESSION['user']);
	unset($_SESSION['fingerprint']);
	unset($_SESSION['last_activity']);
	// Give the current session a new id before saving user information into it
	session_regenerate_id();
}

/**
 * Function to check if the current users access level is 1000, which is equal to Super Admin
 * @return bool
 */
function is_super_admin()
{
	return $_SESSION['user']['access_level'] == 1000 ? true : false;
}

/**
 * Function to check if the fingerprint stored in session, matches to current fingerprint returned from the function fingerprint()
 */
function check_fingerprint()
{
	// If the current fingerprint returned from the function doesn't match the fingerprint stored in session, logout!
	if ( $_SESSION['fingerprint'] != fingerprint() )
	{
		logout();
		header('Location: index.php');
		exit;
	}
}

/**
 * Function to check if the user has been active within the last 30 mins
 */
function check_last_activity()
{
	// If developer status is false, use on session
	if (!DEVELOPER_STATUS)
	{
		// If session last activity is set and the current timestamp + 30 mins is less than current timestamp, log the user out
		if ( isset($_SESSION['last_activity']) && $_SESSION['last_activity'] + 1800 < time() )
		{
			logout();
			header('Location: index.php');
			exit;
		}
		// Or update the session with current timestamp
		else
		{
			$_SESSION['last_activity'] = time();
		}
	}
}

/**
 * @param string $string:	The text to shorten
 * @param int $chars:		The amount of characters to display of the text
 * @return string
 */
function shorten_string($string, $chars)
{
	// Remove tags from string to avoid non-closed tags on cut
	$string = strip_tags($string);

	// If string contains more characters than the amount to display, do this
	if (mb_strlen($string, 'utf8') > $chars)
	{
		// Find the last space within X characters
		$last_space	= strrpos(substr($string, 0, $chars + 1), ' ');
		// Cut string and add ... after the last found space
		$string		= substr($string, 0, $last_space) . '&hellip;';
	}
	return $string;
}

/**
 * Function to send emails with correct header information.
 * @param string $to:		The e-mail address of the reciever of the e-mail
 * @param string $subject:	The subject of the e-mail
 * @param string $message:	The text in the e-mail
 * @param string $from:		The email address of the sender of the e-mail
 * @param string $from_name:The name of the sender of the e-mail
 * @return bool
 */
function send_mail($to, $subject, $message, $from, $from_name)
{
	// To send HTML mail, the Content-type header must be set
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	// Additional headers
	$headers .= "From: ".$from_name." <".$from.">\r\n";

	// Mail it
	return mail($to, $subject, $message, $headers);
}