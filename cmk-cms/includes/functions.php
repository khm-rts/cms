<?php
function alert($type, $message)
{
	?>
	<div class="alert alert-<?php echo $type ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $message ?>
	</div>
	<?php
}

function create_event($type, $description, $access_level)
{
	global $mysqli;

	switch($type)
	{
		case 'create':
			$event_type_id = 1;
			break;
		case 'update':
			$event_type_id = 2;
			break;
		case 'delete':
			$event_type_id = 3;
			break;
		default:
			$event_type_id = 4;
	}

	$description	= $mysqli->real_escape_string($description);
	$access_level	= intval($access_level);
	$user_id		= intval($_SESSION['user']['id']);

	$query =
		"INSERT INTO 
			events (event_description, event_access_level_required, fk_user_id, fk_event_type_id) 
		VALUES 
			('$description', $access_level, $user_id, $event_type_id)";
	$result = $mysqli->query($query);

	// If result returns false, use the function query_error to show debugging info
	if (!$result)
	{
		query_error($query, __LINE__, __FILE__);
	}
}

function connect_error($error_no, $error, $line_number, $file_name)
{
	if (DEVELOPER_STATUS)
	{
		die('<p>Forbindelsesfejl (' . $error_no . '): ' . $error . '</p><p>Linje: ' . $line_number . '</p><p>Fil: ' . $file_name . '</p>');
	}
	else
	{
		die(CONNECT_ERROR);
	}
}

function query_error($query, $line_number, $file_name)
{
	global $mysqli;

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
	else
	{
		alert('danger', SQL_ERROR);
		$mysqli->close();

	}
}

function prettyprint($data)
{
	?>
	<pre class="prettyprint lang-php"><code><?php print_r($data) ?></code></pre>
	<?php
}

/**
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

		global $icons;

		echo '<ul class="pagination">';

		// If current page is greater than 1, show previous button
		if ($page_no > 1)
		{
			echo '<li><a href="index.php?page=' . $page . '&page-no=' . ($page_no - 1) . '" data-page="' . $page . '" data-params="page-no=' . ($page_no - 1) . '">' . $icons['previous'] . '</a></li>';
		}
		// If current page is not greater than 1 and show_disabled_arrows is set to true, show disabled previous link
		else if ($show_disabled_arrows)
		{
			echo '<li class="disabled"><span>' . $icons['previous'] . '</span></li>';
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
			echo '<li><a href="index.php?page=' . $page . '&page-no=' . ($page_no + 1) . '" data-page="' . $page . '" data-params="page-no=' . ($page_no + 1) . '">' . $icons['next'] . '</a></li>';
		}
		// If current page is not smaller than pages total and show_disabled_arrows is set to true, show disabled next link
		else if ($show_disabled_arrows)
		{
			echo '<li class="disabled"><span>' . $icons['next'] . '</span></li>';
		}

		echo '</ul>';
	}
}

function show_developer_info()
{
	?>
	<br>
	<pre class="prettyprint lang-php"><code>GET <?php print_r($_GET) ?></code></pre>
	<pre class="prettyprint lang-php"><code>POST <?php print_r($_POST) ?></code></pre>
	<pre class="prettyprint lang-php"><code>FILES <?php print_r($_FILES) ?></code></pre>
	<pre class="prettyprint lang-php"><code>SESSION <?php print_r($_SESSION) ?></code></pre>
	<pre class="prettyprint lang-php"><code>COOKIE <?php print_r($_COOKIE) ?></code></pre>
	<?php
}

// Take the user agent info from the browser, add a salt and hash the information with the algo sha256
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
		alert('warning', REQUIRED_FIELDS_EMPTY);
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

				// Use function to insert event in log
				create_event('info', '<a href="index.php?page=user-edit&id=' . $row->user_id . '" data-page="user-edit" data-params="id='. $row->user_id . '">' . $row->user_name . '</a>' . ' loggede ind', 100);
				return true;
			}
			// If the typed password didn't match the hashed password in the Database
			else
			{
				alert('warning', EMAIL_OR_PW_INVALID);
			}
		}
		// If no user with the typed email was found in the database, show this alert
		else
		{
			alert('warning', EMAIL_OR_PW_INVALID);
		}
	}
	return false;
}

// Delete the sessions from login and give the session a new id
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

function check_fingerprint()
{
	// If the current fingerprint returned from the function doesn't match the fingerprint stored in session, logout!
	if ( $_SESSION['fingerprint'] != fingerprint() )
	{
		logout();
		?>
		<script type="text/javascript">
			location.href= 'login.php';
		</script>
		<?php
		exit;
	}
}

function check_last_activity()
{
	// If developer status is false, use on session
	if (!DEVELOPER_STATUS)
	{
		// If session last activity is set and the current timestamp + 30 mins is less than current timestamp, log the user out
		if ( isset($_SESSION['last_activity']) && $_SESSION['last_activity'] + 1800 < time() )
		{
			logout();
			?>
			<script type="text/javascript">
				location.href= 'login.php';
			</script>
			<?php
			exit;
		}
		// Or update the session with current timestamp
		else
		{
			$_SESSION['last_activity'] = time();
		}
	}
}

function page_access($page)
{
	global $view_files;

	if ( $view_files[$page]['required_access_lvl'] > $_SESSION['user']['access_level'])
	{
		?>
		<script type="text/javascript">
			location.href= 'index.php';
		</script>
		<?php
		exit;
	}
}