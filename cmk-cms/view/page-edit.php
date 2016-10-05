<?php
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'page-edit';
}

page_access($view_file);
?>

<div class="page-title">
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['page-create']['icon'] . ' ' . $view_files['page-create']['title']
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
		<form method="post" data-page="<?php echo $view_file ?>" data-params="id=<?php echo $_GET['id'] ?>">
			<?php
			if ( !isset($_GET['id']) || empty($_GET['id']) )
			{
				alert('danger', NO_ITEM_SELECTED);
			}
			else
			{
				// Get the selected users id from the URL param
				$id	= intval($_GET['id']);

				// Get the user from the Database
				$query	=
					"SELECT 
						page_url_key, page_title, page_meta_robots, page_meta_description 
					FROM 
						pages 
					WHERE 
						page_id = $id";
				$result = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result)
				{
					query_error($query, __LINE__, __FILE__);
				}

				// Return the information from the Database as an object
				$row	= $result->fetch_object();

				// Save variables with values from the database, to be used in the forms input values
				$title					= $row->page_title;
				$url_key				= $row->page_url_key;
				$meta_robots			= $row->page_meta_robots;
				$meta_description_tmp	= $row->page_meta_description;

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
						if (!$result)
						{
							query_error($query, __LINE__, __FILE__);
						}

						// If any rows was found, the email is not available, so show alert
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
							if (!$result)
							{
								query_error($query, __LINE__, __FILE__);
							}

							// Use function to insert event in log
							create_event('update', 'af siden <a href="index.php?page=' . $view_file . '&id=' . $id . '" data-page="' . $view_file . '" data-params="id='. $id . '">' . $title . '</a>', $view_files[$view_file]['required_access_lvl']);

							alert('success', ITEM_UPDATED . ' <a href="index.php?page=pages" data-page="pages">' . RETURN_TO_OVERVIEW . '</a>');
						} // Closes else to: if ($result->num_rows > 0)
					} // Closes: ( empty($_POST['title']) || empty($_POST['url_key'])...
				} // Closes: if ( isset($_POST['save_item']) )
				include $include_path . 'form-page.php';
			}
			?>
		</form>
	</div>
</div>

<?php
if (DEVELOPER_STATUS) { show_developer_info(); }
