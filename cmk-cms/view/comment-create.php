<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'comment-create';
}

page_access($view_file);

// If post-id is not defined in URL params, or the value is empty, show alert
if ( !isset($_GET['post-id']) || empty($_GET['post-id']) )
{
	alert('danger', NO_ITEM_SELECTED);
}
// If page-id is defined, continue
else
{
	// Get the selected post id from the URL param
	$post_id = intval($_GET['post-id']);

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
		echo $view_files[$view_file]['icon'] . ' ' . $post->post_title
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
			<form method="post" data-page="<?php echo $view_file ?>" data-params="post-id=<?php echo $post_id ?>">
				<?php
				// Save variables with empty values, to be used in the forms input values
				$content_tmp = '';

				// If the form has been submitted
				if ( isset($_POST['save_item']) )
				{
					// Escape inputs and save values to variables defined before with empty value
					$content_tmp = $_POST['content'];
					$user_id	 = intval($_SESSION['user']['id']);

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

						// Insert the comment into the database
						$query =
							"INSERT INTO 
								comments (comment_content, fk_user_id, fk_post_id) 
							VALUES 
								('$content', $user_id, $post_id)";
						$result = $mysqli->query($query);

						// If result returns false, use the function query_error to show debugging info
						if (!$result) query_error($query, __LINE__, __FILE__);

						// Get the newly created comment id
						$comment_id = $mysqli->insert_id;

						// Use function to insert event in log
						create_event('create', 'af <a href="index.php?page=comment-edit&post-id=' . $post_id . '&id=' . $comment_id . '" data-page="comment-edit" data-params="post-id=' . $post_id . '&id=' . $comment_id . '">kommentar</a> til blog-indlægget <a href="index.php?page=post-edit&id=' . $post_id . '" data-page="post-edit" data-params="id=' . $post_id . '">' . $post->post_title . '</a>', $view_files[$view_file]['required_access_lvl']);

						// Use function to display alert
						alert('success', ITEM_CREATED . ' <a href="index.php?page=comments&post-id=' . $post_id . '" data-page="comments" data-params="post-id=' . $post_id . '">' . RETURN_TO_OVERVIEW . '</a>');

					} // Closes: if ( empty($_POST['content'])
				} // Closes: if ( isset($_POST['save_item']) )

				include $include_path . 'form-comment.php'
				?>
			</form>
		</div>
	</div>
	<?php
}

show_developer_info();
