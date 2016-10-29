<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'tag-create';
}

page_access($view_file);
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
			<div class="title"><?php echo CREATE_ITEM ?></div>
		</div>
	</div>

	<div class="card-body">
		<form method="post" data-page="<?php echo $view_file ?>">
			<?php
			// Save variables with empty values, to be used in the forms input values
			$name = '';

			// If the form has been submitted
			if ( isset($_POST['save_item']) )
			{
				// Escape inputs and save values to variables defined before with empty value
				$name		= $mysqli->escape_string($_POST['name']);

				// If one of the required fields is empty, show alert
				if ( empty($_POST['name']) )
				{
					alert('warning', REQUIRED_FIELDS_EMPTY);
				}
				// If all required fields is not empty, continue
				else
				{
					$query =
						"INSERT INTO 
							tags (tag_name) 
						VALUES ('$name')";
					$result = $mysqli->query($query);

					// If result returns false, use the function query_error to show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					// Get the newly created item id
					$id = $mysqli->insert_id;

					// Use function to insert event in log
					create_event('create', 'af tagget <a href="index.php?page=tag-edit&id=' . $id . '" data-page="tag-edit" data-params="id='. $id . '">' . $name . '</a>', $view_files[$view_file]['required_access_lvl']);

					alert('success', ITEM_CREATED . ' <a href="index.php?page=tags" data-page="tags">' . RETURN_TO_OVERVIEW . '</a>');
				} // Closes: if ( empty($_POST['name']) )
			} // Closes: if ( isset($_POST['save_item']) )

			include $include_path . 'form-tag.php'
			?>
		</form>
	</div>
</div>

<?php
show_developer_info();
