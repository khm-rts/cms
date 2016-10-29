<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'category-edit';
}

page_access($view_file);

// If id is not defined in URL params, or the value is empty, show alert
if ( !isset($_GET['id']) || empty($_GET['id']) )
{
	alert('danger', NO_ITEM_SELECTED);
}
else
{
	// Get the selected item id from the URL param
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
						category_name, category_url_key  
					FROM 
						categories 
					WHERE 
						category_id = $id";
					$result = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);

				// Return the information from the Database as an object
				$row	= $result->fetch_object();

				// Save variables with values from the database, to be used in the forms input values
				$name		= $row->category_name;
				$url_key	= $row->category_url_key;

				// If the form has been submitted
				if ( isset($_POST['save_item']) )
				{
					// Escape inputs and save values to variables defined before with empty value
					$name		= $mysqli->escape_string($_POST['name']);
					$url_key	= $mysqli->escape_string($_POST['url_key']);

					// If one of the required fields is empty, show alert
					if ( empty($_POST['name']) || empty($_POST['url_key']) )
					{
						alert('warning', REQUIRED_FIELDS_EMPTY);
					}
					// If all required fields is not empty, continue
					else
					{
						// Match items with this url_key and not the current item
						$query =
							"SELECT 
								category_id 
							FROM 
								categories
							WHERE 
								category_url_key = '$url_key'
							AND 
								category_id != $id";
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
							// Update the item in the database
							$query =
								"UPDATE 
									categories 
								SET 
									category_name = '$name', category_url_key = '$url_key'
								WHERE 
									category_id = $id";
								$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							// Use function to insert event in log
							create_event('update', 'af kategorien <a href="index.php?page=' . $view_file . '&id=' . $id . '" data-page="' . $view_file . '" data-params="id='. $id . '">' . $name . '</a>', $view_files[$view_file]['required_access_lvl']);

							alert('success', ITEM_UPDATED . ' <a href="index.php?page=categories" data-page="categories">' . RETURN_TO_OVERVIEW . '</a>');
						} // Closes else to: if ($result->num_rows > 0)
					} // Closes: if ( empty($_POST['name']) || empty($_POST['url_key']) )
				} // Closes: if ( isset($_POST['save_item']) )
				include $include_path . 'form-category.php';
				?>
			</form>
		</div>
	</div>
	<?php
}

show_developer_info();
