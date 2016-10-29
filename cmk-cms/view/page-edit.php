<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'page-edit';
}

page_access($view_file);

// If id is not defined in URL params, or the value is empty, show alert
if ( !isset($_GET['id']) || empty($_GET['id']) )
{
	alert('danger', NO_ITEM_SELECTED);
}
else
{
	// Get the selected page id from the URL param
	$id	= intval($_GET['id']);

	?>
	<div class="page-title">
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files[$view_file]['icon'] . ' ' . $view_files[$view_file]['title']
		?>
	</span>
	</div>

	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<div class="title"><?php echo EDIT_ITEM ?></div>
			</div>
		</div>

		<div class="card-body">
			<form method="post" data-page="<?php echo $view_file ?>" data-params="id=<?php echo $id ?>">
				<?php
				// Get the page from the Database
				$query	=
					"SELECT 
						page_url_key, page_title, page_meta_robots, page_meta_description, menu_link_id, menu_link_name, GROUP_CONCAT(menu_id) AS menus  
					FROM 
						pages 
					LEFT JOIN
						menu_links ON pages.page_id = menu_links.fk_page_id
					AND
						menu_links.fk_link_type_id = 1
					INNER JOIN
						menus_menu_links ON menu_links.menu_link_id = menus_menu_links.fk_menu_link_id
					INNER JOIN
						menus ON menus_menu_links.fk_menu_id = menus.menu_id
					WHERE 
						page_id = $id";
					$result = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);

				// Return the information from the Database as an object
				$row	= $result->fetch_object();

				// Save variables with values from the database, to be used in the forms input values
				$title					= $row->page_title;
				$url_key				= $row->page_url_key;
				$meta_robots			= $row->page_meta_robots;
				$meta_description_tmp	= $row->page_meta_description;

				// If menus is defined, convert CSV with menu_id to array menus with explode
				$menus		= isset($row->menus) ? explode(',', $row->menus) : [];
				$link_id	= $row->menu_link_id;
				$link_name	= $row->menu_link_name;

				// If the form has been submitted
				if ( isset($_POST['save_item']) )
				{
					// Escape inputs and save values to variables defined before with empty value
					$title					= $mysqli->escape_string($_POST['title']);
					$url_key				= $mysqli->escape_string($_POST['url_key']);
					$meta_robots			= $mysqli->escape_string($_POST['meta_robots']);
					$meta_description_tmp	= $_POST['meta_description'];

					// If one of the required fields is empty, show alert
					if ( empty($_POST['title']) || empty($_POST['meta_robots']) )
					{
						alert('warning', REQUIRED_FIELDS_EMPTY);
					}
					// If all required fields is not empty, continue
					else
					{
						// Match pages with this url_key and not the current page
						$query =
							"SELECT 
								page_id 
							FROM 
								pages 
							WHERE 
								page_url_key = '$url_key'
							AND 
								page_id != $id";
							$result = $mysqli->query($query);

						// If result returns false, use the function query_error to show debugging info
						if (!$result) query_error($query, __LINE__, __FILE__);

						// If any rows was found, the url key is not available, so show alert
						if ($result->num_rows > 0)
						{
							alert('warning', URL_NOT_AVAILABLE);
						}
						// If url_key is available, continue
						else
						{
							// If meta_description is empty, save NULL value to the variable meta_description and if not escape the value from the form and add single quotes
							$meta_description = empty($_POST['meta_description']) ? 'NULL' : "'" . $mysqli->escape_string($_POST['meta_description']) . "'";

							// Update the page in the database
							$query =
								"UPDATE 
									pages 
								SET 
									page_url_key = '$url_key', page_title = '$title', page_meta_robots = '$meta_robots', page_meta_description = $meta_description
								WHERE 
									page_id = $id";
								$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							// Use function to insert event in log
							create_event('update', 'af siden <a href="index.php?page=' . $view_file . '&id=' . $id . '" data-page="' . $view_file . '" data-params="id='. $id . '">' . $title . '</a>', $view_files[$view_file]['required_access_lvl']);

							alert('success', ITEM_UPDATED . ' <a href="index.php?page=pages" data-page="pages">' . RETURN_TO_OVERVIEW . '</a>');

							// If link_to_page is posted, create or update link to this page for the selected menus
							if ( isset($_POST['link_to_page']) )
							{
								// If link exist and either menus or link_name is changed, we use the update function
								if ( isset($link_id) && ( (isset($_POST['menus']) && $menus != $_POST['menus']) || $link_name != $_POST['link_name'] ) )
								{
									$menus					= $_POST['menus'];
									$link_name				= $mysqli->escape_string($_POST['link_name']);
									update_menu_link($menus, $link_id, $link_name, $id);
								}
								// If link_id is not defined, the link doesn't exist and we use the create function
								else if ( !isset($link_id) )
								{
									$menus					= isset($_POST['menus']) ? $_POST['menus'] : [];
									$link_name				= $mysqli->escape_string($_POST['link_name']);
									create_menu_link($menus, $link_name, $id);
								}
							}
							// If link_to_page is not posted, we have unchecked link to this page, so if link_id is defined, we use the delete function to delete it
							else if ( isset($link_id) )
							{
								delete_menu_link($link_id);
								$menus		= []; // reset selected menus
								$link_name	= ''; // reset link name
							}
						} // Closes else to: if ($result->num_rows > 0)
					} // Closes: ( empty($_POST['title']) || empty($_POST['url_key'])...
				} // Closes: if ( isset($_POST['save_item']) )
				include $include_path . 'form-page.php';
				?>
			</form>
		</div>
	</div>
	<?php
}

show_developer_info();
