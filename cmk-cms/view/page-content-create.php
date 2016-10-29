<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'page-content-create';
}

page_access($view_file);

// If page-id is not defined in URL params, or the value is empty, show alert
if ( !isset($_GET['page-id']) || empty($_GET['page-id']) )
{
	alert('danger', NO_ITEM_SELECTED);
}
// If page-id is defined, continue
else
{
	// Get the selected page id from the URL param
	$page_id = intval($_GET['page-id']);

	// Get the page from the Database
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

	// Return the information from the Database as an object
	$row	= $result->fetch_object();

	?>
	<div class="page-title">
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files[$view_file]['icon'] . ' ' . $row->page_title
		?>
	</span>
	</div>

	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<div class="title"><?php echo CREATE_ITEM ?></div>
			</div>
		</div>

		<div class="card-body">
			<form method="post" data-page="<?php echo $view_file ?>" data-params="page-id=<?php echo $page_id ?>">
				<?php
				// Save variables with empty values, to be used in the forms input values
				$description_tmp = $content_tmp = $page_function_tmp = $layout = '';
				$content_type = 1;

				// If the form has been submitted
				if ( isset($_POST['save_item']) )
				{
					// Escape inputs and save values to variables defined before with empty value
					$content_type		= intval($_POST['content_type']);
					$layout				= intval($_POST['layout']);
					$description_tmp	= $_POST['description'];
					$content_tmp 		= $_POST['content'];
					$page_function_tmp	= $_POST['page_function'];


					// If content type or layout is empty. Or content type is 1 and description or content is empty. Or content type is 2 and page function is empty, show alert
					if ( empty($_POST['content_type']) || empty($_POST['layout']) || ( $content_type == 1 && ( empty($_POST['description']) || empty($_POST['content']) ) ) || ( $content_type == 2 && empty($_POST['page_function']) ) )
					{
						alert('warning', REQUIRED_FIELDS_EMPTY);
					}
					// If all required fields is not empty, continue
					else
					{

						// If content type is 1, escape strings and add quotes to the string. Also set $page_function to NULL, because it's not needed
						if ($content_type == 1)
						{
							$description	= "'" . $mysqli->escape_string($description_tmp) . "'";
							$content		= "'" . $mysqli->escape_string($content_tmp) . "'";
							$page_function	= 'NULL';
						}
						// If content type is 2, use intval on value for page_function. Also set $description and $content to NULL, because it's not needed
						else
						{
							$description	= 'NULL';
							$content		= 'NULL';
							$page_function	= intval($_POST['page_function']);
						}

						// Get the new order for the new content being created
						$query =
							"SELECT 
								COUNT(*) AS count 
							FROM 
								page_content 
							WHERE 
								fk_page_id = $page_id";
						$result = $mysqli->query($query);

						// If result returns false, use the function query_error to show debugging info
						if (!$result) query_error($query, __LINE__, __FILE__);

						$row = $result->fetch_object();
						// Set the new order to counted items plus 1, so new content is adding last in order
						$new_order = $row->count + 1;

						// Insert the page-content to the database
						$query =
							"INSERT INTO 
								page_content (page_content_order, page_content_type, page_content_description, page_content, fk_page_function_id, fk_page_layout_id, fk_page_id) 
							VALUES 
								($new_order, $content_type, $description, $content, $page_function, $layout, $page_id)";
						$result = $mysqli->query($query);

						// If result returns false, use the function query_error to show debugging info
						if (!$result) query_error($query, __LINE__, __FILE__);

						// Get the newly created page content id
						$page_content_id = $mysqli->insert_id;

						// If content type is 1, use the posted description
						if ($content_type == 1)
						{
							$content_description = $description;
						}
						// If content type is 2, use the description from the page function
						else
						{
							// Get the description for the page function
							$query	=
								"SELECT 
									page_function_description
								FROM 
									page_functions 
								WHERE 
									page_function_id = $page_function";
							$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							$row = $result->fetch_object();
							$content_description = $row->page_function_description;
						}

						// Get the title for the page
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

						// Use function to insert event in log
						create_event('create', 'af indholdet <a href="index.php?page=page-content-edit&page-id=' . $page_id . '&id= ' . $page_content_id . '" data-page="page-content-edit" data-params="page-id=' . $page_id . '&id= ' . $page_content_id . '">' . $content_description . '</a> på siden <a href="index.php?page=page-edit&id=' . $page_id . '" data-page="page-edit" data-params="id='. $page_id . '">' . $row->page_title . '</a>', $view_files[$view_file]['required_access_lvl']);

						// Use function to display alert
						alert('success', ITEM_CREATED . ' <a href="index.php?page=page-content&page-id=' . $page_id . '" data-page="page-content" data-params="page-id='. $page_id .'">' . RETURN_TO_OVERVIEW . '</a>');

					} // Closes: if ( empty($_POST['content_type']) || empty($_POST['layout'])...
				} // Closes: if ( isset($_POST['save_item']) )

				include $include_path . 'form-page-content.php'
				?>
			</form>
		</div>
	</div>
	<?php
}

show_developer_info();
