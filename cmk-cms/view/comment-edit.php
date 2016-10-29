<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'page-content-edit';
}

page_access($view_file);

// If post-id is not defined in URL params, or the value is empty, show alert
if ( !isset($_GET['post-id']) || empty($_GET['post-id']) || !isset($_GET['id']) || empty($_GET['id']) )
{
	alert('danger', NO_ITEM_SELECTED);
}
// If page-id is defined, continue
else
{
	// Get the selected post id and id from the URL params
	$post_id = intval($_GET['post-id']);
	$id 	 = intval($_GET['id']);

	// Get the title for the post
	$query	=
			"SELECT 
				post_title
			FROM 
				posts 
			WHERE 
				post_id = $post_id";
	$result = $mysqli->query($query);

	// If result returns false, use the function query_error to show debugging info
	if (!$result) query_error($query, __LINE__, __FILE__);

	$post = $result->fetch_object();

	?>
	<div class="page-title">
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['comment-edit']['icon'] . ' ' . $post->post_title
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
			<form method="post" data-page="comment-edit" data-params="post-id=<?php echo $post_id ?>&id=<?php echo $id ?>">
				<?php
				// Get info for the comment
				$query	=
					"SELECT 
						comment_content
					FROM 
						comments 
					WHERE 
						comment_id = $id";
				$result = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);

				$row = $result->fetch_object();

				// Save variables with values from the database, to be used in the forms input values
				$content_tmp = $row->comment_content;

				// If the form has been submitted
				if ( isset($_POST['save_item']) )
				{
					// Escape inputs and save values to variables defined before with empty value
					$content_tmp = $_POST['content'];

					// If content is empty, show alert
					if ( empty($_POST['content']) )
					{
						alert('warning', REQUIRED_FIELDS_EMPTY);
					}
					// If all required fields is not empty, continue
					else
					{
						// Escape content before using variable in sql
						$content = $mysqli->escape_string($content_tmp);

						// Update the comment in the database
						$query =
							"UPDATE 
								comments
							SET
								comment_content = '$content' 
							WHERE
								comment_id = $id";
						$result = $mysqli->query($query);

						// If result returns false, use the function query_error to show debugging info
						if (!$result) query_error($query, __LINE__, __FILE__);

						// Use function to insert event in log
						create_event('update', 'af <a href="index.php?page=comment-edit&post-id=' . $post_id . '&id=' . $id . '" data-page="comment-edit" data-params="post-id=' . $post_id . '&id=' . $id . '">kommentar</a> til blog-indlægget <a href="index.php?page=post-edit&id=' . $post_id . '" data-page="post-edit" data-params="id=' . $post_id . '">' . $post->post_title . '</a>', $view_files[$view_file]['required_access_lvl']);

						// Use function to display alert
						alert('success', ITEM_UPDATED . ' <a href="index.php?page=comments&post-id=' . $post_id . '" data-page="comments" data-params="post-id=' . $post_id . '">' . RETURN_TO_OVERVIEW . '</a>');

					} // Closes: if ( empty($_POST['content'])
				} // Closes: if ( isset($_POST['save_item']) )

				include $include_path . 'form-comment.php';
				?>
			</form>
		</div>
	</div>
	<?php
}

show_developer_info();
