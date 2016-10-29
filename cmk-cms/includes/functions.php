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
		alert('danger', SQL_ERROR);
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
 * Function to insert a new event into the logbook
 * @param string $type:			The name that matches the type of event. create || update || delete etc.
 * @param string $description:	The text that descripe what has happened when this function is runned
 * @param int $access_level:	The required access level for the action that took place
 */
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

/**
 * Function to create link and relation to menus. Used on page-create.php and menu-link-create.php
 * @param array	$menus: 		id for selected menus we wan't the link in
 * @param string $name:			the visible name of the link in the menu
 * @param int $page_id:			id for the page being linked to
 * @param int $link_type:		type of link. 1: Just link to a page, 2: link to post on a page, 3: link to bookmark on a page
 * @param string $bookmark_tmp:	Optional value of id for a bookmark on a page, when link type is set to 3
 * @param int $post_id_tmp:		Optional id to a post, when link type is set to 2
 */
function create_menu_link($menus, $name, $page_id, $link_type = 1, $bookmark_tmp = NULL, $post_id_tmp = NULL)
{
	// If one of the required fields is empty
	if ( empty($menus) || empty($name) || empty($page_id) || ( $link_type == 2 && empty($post_id_tmp) ) || ( $link_type == 3 && empty($bookmark_tmp) ) )
	{
		alert('warning', REQUIRED_FIELDS_EMPTY);
	}
	// If all required fields is not empty, continue
	else
	{
		global $mysqli, $view_files;

		switch ($link_type)
		{
			// If link type is 2, use intval and save value in $post and set $bookmark to NULL, because it's not needed
			case 2:
				$post_id	= intval($post_id_tmp);
				$bookmark	= 'NULL';
				break;
			// If link type is 3, use escape string, add quotes and save value in $bookmark and set $post_id to NULL, because it's not needed
			case 3:
				$post_id	= 'NULL';
				$bookmark	= "'" . $mysqli->escape_string($bookmark_tmp) . "'";
				break;
			// If link type is not 2 or 3, set both $post_id and $bookmark to NULL, because they aren't not needed
			default:
				$post_id	= 'NULL';
				$bookmark	= 'NULL';
		}

		// Insert the menu-link into the database
		$query =
			"INSERT INTO 
				menu_links (menu_link_name, menu_link_bookmark, fk_link_type_id, fk_page_id, fk_post_id) 
			VALUES 
				('$name', $bookmark, $link_type, $page_id, $post_id)";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		// Get the newly created menu link id
		$menu_link_id = $mysqli->insert_id;

		// Create relation between newly created link and the selected menus
		foreach ($menus as $menu)
		{
			$menu_id = intval($menu);

			// Get the new order for the new link being created
			$query =
				"SELECT 
					COUNT(*) AS count 
				FROM 
					menus_menu_links 
				WHERE 
					fk_menu_id = $menu_id";
			$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			$row = $result->fetch_object();
			// Set the new order to counted items plus 1, so new content is adding last in order
			$new_order = $row->count + 1;

			$query =
				"INSERT INTO
					menus_menu_links (menu_link_order, fk_menu_id, fk_menu_link_id)
				VALUES
					($new_order, $menu_id, $menu_link_id)";
			$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);
		}

		// If link type is 2 (link to post), use this text to event
		if ($link_type == 2)
		{
			$query =
				"SELECT 
					post_title
				FROM 
					posts
				WHERE
					post_id = $post_id";
				$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			$row = $result->fetch_object();

			$event_txt = 'til blog-indlægget <a href="index.php?page=post-edit&id=' . $post_id . '">' . $row->post_title . '</a>';
		}
		// If link type is not 2, get page_title to use in text to event
		else
		{
			// Get the title for the page linked to
			$query	=
				"SELECT 
					page_title
				FROM 
					pages 
				WHERE 
					page_id = $page_id";
			$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			$row = $result->fetch_object();

			// If link type is 3 (link to bookmark), use this text to event
			if ($link_type == 3)
			{
				$event_txt = 'til bogmærket ' . $bookmark_tmp . ' på siden <a href="index.php?page=page-edit&id=' . $page_id . '" data-page="page-edit" data-params="id='. $page_id . '">' . $row->page_title . '</a>';
			}
			// If link type is not 2 or 3, use this text to event
			else
			{
				$event_txt = 'til siden <a href="index.php?page=page-edit&id=' . $page_id . '" data-page="page-edit" data-params="id='. $page_id . '">' . $row->page_title . '</a>';
			}
		}

		// Use function to insert event in log (just show link for last menu in array menus, so we use end(), to take the last value)
		create_event('create', 'af link <a href="index.php?page=menu-link-edit&menu-id=' . end($menus) . '&id= ' . $menu_link_id . '" data-page="menu-link-edit" data-params="menu-id=' . end($menus) . '&id= ' . $menu_link_id . '">' . $name . '</a> ' . $event_txt, $view_files['menu-link-create']['required_access_lvl']);

		// Use function to insert event in log
		alert('success', ITEM_CREATED . ' <a href="index.php?page=menu-links&menu-id=' . end($menus) . '" data-page="menu-links" data-params="menu-id='. end($menus) .'">' . RETURN_TO_OVERVIEW . '</a>');
	} // Closes: if ( empty($menus) || empty($name) || empty($link_type)...
}

/**
 * Function to update link and relation to menus. Used on page-edit.php and menu-link-edit.php
 * @param array	$menus: 		id for selected menus we wan't the link in
 * @param int $menu_link_id:	id for the link being updated
 * @param string $name:			the visible name of the link in the menu
 * @param int $page_id:			id for the page being linked to
 * @param int $link_type:		type of link. 1: Just link to a page, 2: link to post on a page, 3: link to bookmark on a page
 * @param string $bookmark_tmp:	Optional value of id for a bookmark on a page, when link type is set to 3
 * @param int $post_id_tmp:		Optional id to a post, when link type is set to 2
 */
function update_menu_link($menus, $menu_link_id, $name, $page_id, $link_type = 1, $bookmark_tmp = NULL, $post_id_tmp = NULL)
{
	// If one of the required fields is empty
	if ( empty($menus) || empty($name) || empty($page_id) || ( $link_type == 2 && empty($post_id_tmp) ) || ( $link_type == 3 && empty($bookmark_tmp) ) )
	{
		alert('warning', REQUIRED_FIELDS_EMPTY);
	}
	// If all required fields is not empty, continue
	else
	{
		global $mysqli, $view_files;

		switch ($link_type)
		{
			// If link type is 2, use intval and save value in $post and set $bookmark to NULL, because it's not needed
			case 2:
				$post_id	= intval($post_id_tmp);
				$bookmark	= 'NULL';
				break;
			// If link type is 3, use escape string, add quotes and save value in $bookmark and set $post_id to NULL, because it's not needed
			case 3:
				$post_id	= 'NULL';
				$bookmark	= "'" . $mysqli->escape_string($bookmark_tmp) . "'";
				break;
			// If link type is not 2 or 3, set both $post_id and $bookmark to NULL, because they aren't not needed
			default:
				$post_id	= 'NULL';
				$bookmark	= 'NULL';
		}

		// Update the menu-link in the database
		$query =
			"UPDATE 
				menu_links
			SET 
				menu_link_name = '$name', menu_link_bookmark = $bookmark, fk_link_type_id = $link_type, fk_page_id = $page_id, fk_post_id = $post_id 
			WHERE
				menu_link_id = $menu_link_id";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		// Get menu_id's for current relations between menu links and menus
		$query =
				"SELECT
					GROUP_CONCAT(fk_menu_id) as menus
				FROM
					menus_menu_links
				WHERE
					fk_menu_link_id = $menu_link_id";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		$row = $result->fetch_object();
		// Convert CSV with current menu_id's to array
		$current_menus = explode(',', $row->menus);
		// Compare selected $menus with $current_menus and save new items from $menus to new array: $new_menus (items to create)
		$new_menus = array_diff($menus, $current_menus);
		// Compare $current_menus with $menus and save old items from $current_menus to new array: $old_menus (items to delete)
		$old_menus = array_diff($current_menus, $menus);
		// Convert array to CSV to match items in database
		$old_menus_csv = implode(',', $old_menus);

		// If there are any items to delete
		if ( count($old_menus) > 0 )
		{
			delete_menu_link($menu_link_id, $old_menus_csv);
		}

		// If there's any items to create
		if ( count($new_menus) > 0 )
		{
			// Insert relations between updated link and the selected menus
			foreach ($new_menus as $new_menu)
			{
				$menu_id = intval($new_menu);

				// Get the new order for the new link being created
				$query =
						"SELECT 
							COUNT(*) AS count 
						FROM 
							menus_menu_links 
						WHERE 
							fk_menu_id = $menu_id";
				$result = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);

				$row = $result->fetch_object();
				// Set the new order to counted items plus 1, so new content is adding last in order
				$new_order = $row->count + 1;

				$query =
						"INSERT INTO
							menus_menu_links (menu_link_order, fk_menu_id, fk_menu_link_id)
						VALUES
							($new_order, $menu_id, $menu_link_id)";
				$result = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);
			}
		}

		// If link type is 2 (link to post), use this text to event
		if ($link_type == 2)
		{
			$query =
					"SELECT 
						post_title
					FROM 
						posts
					WHERE
						post_id = $post_id";
			$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			$row = $result->fetch_object();

			$event_txt = 'til blog-indlægget <a href="index.php?page=post-edit&id=' . $post_id . '">' . $row->post_title . '</a>';
		}
		// If link type is not 2, get page_title to use in text to event
		else
		{
			// Get the title for the page linked to
			$query	=
					"SELECT 
						page_title
					FROM 
						pages 
					WHERE 
						page_id = $page_id";
			$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			$row = $result->fetch_object();

			// If link type is 3 (link to bookmark), use this text to event
			if ($link_type == 3)
			{
				$event_txt = 'til bogmærket ' . $bookmark_tmp . ' på siden <a href="index.php?page=page-edit&id=' . $page_id . '" data-page="page-edit" data-params="id='. $page_id . '">' . $row->page_title . '</a>';
			}
			// If link type is not 2 or 3, use this text to event
			else
			{
				$event_txt = 'til siden <a href="index.php?page=page-edit&id=' . $page_id . '" data-page="page-edit" data-params="id='. $page_id . '">' . $row->page_title . '</a>';
			}
		}

		// Use function to insert event in log (just show link for last menu in array menus, so we use end(), to take the last value)
		create_event('update', 'af link <a href="index.php?page=menu-link-edit&menu-id=' . end($menus) . '&id= ' . $menu_link_id . '" data-page="menu-link-edit" data-params="menu-id=' . end($menus) . '&id= ' . $menu_link_id . '">' . $name . '</a> ' . $event_txt, $view_files['menu-link-create']['required_access_lvl']);

		// Use function to insert event in log
		alert('success', ITEM_UPDATED . ' <a href="index.php?page=menu-links&menu-id=' . end($menus) . '" data-page="menu-links" data-params="menu-id='. end($menus) .'">' . RETURN_TO_OVERVIEW . '</a>');
	} // Closes: if ( empty($menus) || empty($name) || empty($link_type)...
}

/**
 * Function to delete relation between link and menus or the link entirely. Used in update_menu_link(), menu-links.php, page-edit.php
 * @param int $menu_link_id: id to the link being deleted
 * @param null/csv $menus_csv: id to menus where the relation should be deleted
 */
function delete_menu_link($menu_link_id, $menus_csv = NULL)
{
	global $mysqli, $view_files;

	// Get info to the link from the Database
	$query =
			"SELECT 
				menu_link_name, menu_link_bookmark, fk_link_type_id, page_id, page_title, post_id, post_title
			FROM 
				menu_links 
			INNER JOIN 
				pages ON menu_links.fk_page_id = pages.page_id
			LEFT JOIN 
				posts ON menu_links.fk_post_id = posts.post_id
			WHERE 
				menu_link_id = $menu_link_id";
	$result = $mysqli->query($query);

	// If result returns false, use the function query_error to show debugging info
	if (!$result) query_error($query, __LINE__, __FILE__);

	// Delete the selected link if found
	if ($result->num_rows > 0)
	{
		// Return the information from the Database as an object
		$row = $result->fetch_object();

		// If $menus_csv is defined, only update order for this menu
		$menu_sql = '';
		if ( isset($menus_csv) )
		{
			$menu_sql =
				"
				AND
					fk_menu_id IN ($menus_csv)";
		}

		// Get info for relation between link and menus being deleted, to update order
		$query =
				"SELECT
					menu_link_order, fk_menu_id
				FROM
					menus_menu_links
				WHERE
					fk_menu_link_id = $menu_link_id $menu_sql";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		while( $row_update = $result->fetch_object() )
		{
			$current_order	= $row_update->menu_link_order;
			$current_menu	= $row_update->fk_menu_id;

			// Update order on relation between link and the current menu, with higher order than the one deleted
			$query =
					"UPDATE 
						menus_menu_links 
					SET 
						menu_link_order = menu_link_order - 1 
					WHERE 
						menu_link_order > $current_order 
					AND 
						fk_menu_id = $current_menu";
			$result_update = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result_update) query_error($query, __LINE__, __FILE__);
		}

		// Delete relation between link and selected menus
		$query =
				"DELETE FROM
					menus_menu_links
				WHERE
					fk_menu_link_id = $menu_link_id $menu_sql";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		// Get the relations between link and menus after delete
		$query =
				"SELECT
					fk_menu_id
				FROM 
					menus_menu_links
				WHERE 
					fk_menu_link_id = $menu_link_id";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		// If there's no relations left, delete the link
		if ($result->num_rows == 0)
		{
			$query =
					"DELETE FROM
						menu_links
					WHERE 
						menu_link_id = $menu_link_id";
			$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);
		}

		switch ($row->fk_link_type_id)
		{
			case 2:
				$event_txt = 'til blog-indlægget <a href="index.php?page=post-edit&id=' . $row->post_id . '">' . $row->post_title . '</a>';
				break;
			case 3:
				$event_txt = 'til bogmærket ' . $row->menu_link_bookmark . ' på siden <a href="index.php?page=page-edit&id=' . $row->page_id . '" data-page="page-edit" data-params="id=' . $row->page_id . '">' . $row->page_title . '</a>';
				break;
			default:
				$event_txt = 'til siden <a href="index.php?page=page-edit&id=' . $row->page_id . '" data-page="page-edit" data-params="id=' . $row->page_id . '">' . $row->page_title . '</a>';
		}

		// Opret delete event i logbogen.
		create_event('delete', 'af linket ' . $row->menu_link_name . ' ' . $event_txt, $view_files['menu-links']['required_access_lvl']);
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
		?>
		<script type="text/javascript">
			location.href= 'login.php';
		</script>
		<?php
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

/**
 * Function to check if the user has the required access level for the page where this function is runned
 * @param string $page: Filename without extension from view folder and array $view_files defined in config.php
 *
 */
function page_access($page)
{
	global $view_files;

	if ( $view_files[$page]['required_access_lvl'] > $_SESSION['user']['access_level'])
	{
		?>
		<script type="text/javascript">
			location.href= '../../../index.php';
		</script>
		<?php
		exit;
	}
}