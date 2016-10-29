<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'post-create';
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
			$title = $url_key = $content_tmp = $meta_description_tmp = $category_id_tmp = $tags = $page_id = $link_name = '';
			$menus = [];

			// If the form has been submitted
			if ( isset($_POST['save_item']) )
			{
				// Escape inputs and save values to variables defined before with empty value
				$title					= $mysqli->escape_string($_POST['title']);
				$url_key				= $mysqli->escape_string($_POST['url_key']);
				$content_tmp			= $_POST['content'];
				$meta_description_tmp	= $_POST['meta_description'];
				$category_id_tmp		= $_POST['category'];
				$tags					= $_POST['tags'];
				$menus					= isset($_POST['menus']) ? $_POST['menus'] : [];
				$link_name				= $mysqli->escape_string($_POST['link_name']);
				$page_id				= intval($_POST['page']);
				$user_id				= intval($_SESSION['user']['id']);

				// If one of the required fields is empty, show alert
				if ( empty($_POST['title']) || empty($_POST['url_key']) || empty($_POST['content']) )
				{
					alert('warning', REQUIRED_FIELDS_EMPTY);
				}
				// If all required fields is not empty, continue
				else
				{
					// Match posts with this url_key
					$query =
						"SELECT 
							post_id 
						FROM 
							posts 
						WHERE 
							post_url_key = '$url_key'";
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
						// Escape content before using variable in sql
						$content = $mysqli->escape_string($content_tmp);

						// If meta_description is empty, save NULL value to the variable meta_description and if not escape the value from the form and add single quotes
						$meta_description = empty($_POST['meta_description']) ? 'NULL' : "'" . $mysqli->escape_string($_POST['meta_description']) . "'";

						// If category is empty, save NULL value to the variable $category and if not secure the value is a number
						$category = empty($_POST['category']) ? 'NULL' : intval($_POST['category']);

						// Insert the post into the database
						$query =
								"INSERT INTO 
									posts (post_url_key, post_title, post_content, post_meta_description, fk_user_id, fk_category_id) 
								VALUES
									('$url_key', '$title', '$content', $meta_description, $user_id, $category)";
						$result = $mysqli->query($query);

						// If result returns false, use the function query_error to show debugging info
						if (!$result) query_error($query, __LINE__, __FILE__);

						// Get the newly created post id
						$post_id = $mysqli->insert_id;

						// If any tags was selected, do this
						if ( isset($_POST['tags']) && count($_POST['tags']) > 0 )
						{
							// Loop through the selected tags
							foreach($_POST['tags'] as $tag)
							{
								// Secure that  each value is a number before using in sql
								$tag_id = intval($tag);

								// Insert selected tags in the relation table between posts and tags
								$query =
										"INSERT INTO
											posts_tags (fk_post_id, fk_tag_id)
										VALUES
											($post_id, $tag_id)";
								$result = $mysqli->query($query);

								// If result returns false, use the function query_error to show debugging info
								if (!$result) query_error($query, __LINE__, __FILE__);
							}
						}

						// Use function to insert event in log
						create_event('create', 'af blog-indlægget <a href="index.php?page=post-edit&id=' . $post_id . '" data-page="post-edit" data-params="id='. $post_id . '">' . $title . '</a>', $view_files[$view_file]['required_access_lvl']);

						alert('success', ITEM_CREATED . ' <a href="index.php?page=posts" data-page="posts">' . RETURN_TO_OVERVIEW . '</a>');

						// If link_to_page is posted, create link to this post for the selected menus
						if ( isset($_POST['link_to_page']) )
						{
							create_menu_link($menus, $link_name, $page_id, 2, NULL, $post_id);
						}
					} // Closes else to: if ($result->num_rows > 0)
				} // Closes: ( empty($_POST['title']) || empty($_POST['url_key'])...
			} // Closes: if ( isset($_POST['save_item']) )

			include $include_path . 'form-post.php'
			?>
		</form>
	</div>
</div>

<?php
show_developer_info();
