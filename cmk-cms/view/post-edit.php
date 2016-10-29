<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'post-edit';
}

page_access($view_file);

// If id is not defined in URL params, or the value is empty, show alert
if ( !isset($_GET['id']) || empty($_GET['id']) )
{
	alert('danger', NO_ITEM_SELECTED);
}
else
{
	// Get the selected id from the URL param
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
				// Get the post from the Database with info for the user who created the post and optionally tags and links to the post
				$query	=
						"SELECT 
							post_url_key, post_title, post_content, post_meta_description, fk_category_id, user_id, role_access_level, GROUP_CONCAT(fk_tag_id) AS tags, menu_link_id, menu_link_name, fk_page_id, GROUP_CONCAT(menu_id) AS menus  
						FROM 
							posts
						INNER JOIN
							users ON posts.fk_user_id = users.user_id
						INNER JOIN
							roles ON users.fk_role_id = roles.role_id
						LEFT JOIN
							posts_tags ON posts.post_id = posts_tags.fk_post_id
						LEFT JOIN
							menu_links ON posts.post_id = menu_links.fk_post_id
						AND
							menu_links.fk_link_type_id = 2
						INNER JOIN
							menus_menu_links ON menu_links.menu_link_id = menus_menu_links.fk_menu_link_id
						INNER JOIN
							menus ON menus_menu_links.fk_menu_id = menus.menu_id
						WHERE 
							post_id = $id";
				$result = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);

				// Return the information from the Database as an object
				$row	= $result->fetch_object();

				// Only edit the current post if it's the users own post or the creators access level is below the current users or current user is super admin
				if ($row->user_id == $_SESSION['user']['id'] || $row->role_access_level < $_SESSION['user']['access_level'] || is_super_admin() )
				{
					// Save variables with values from the database, to be used in the forms input values
					$title					= $row->post_title;
					$url_key				= $row->post_url_key;
					$content_tmp			= $row->post_content;
					$meta_description_tmp	= $row->post_meta_description;
					$category_id_tmp		= $row->fk_category_id;

					// If tags or menus is defined, convert CSV with tag_id and menu_id to arrays in the vaiables $tags and $menus with the use of the function explode.
					$tags		= isset($row->tags)		? explode(',', $row->tags)	: [];
					$menus		= isset($row->menus)	? explode(',', $row->menus)	: [];
					$link_id	= $row->menu_link_id;
					$link_name	= $row->menu_link_name;
					$page_id	= $row->fk_page_id;

					// If the form has been submitted
					if ( isset($_POST['save_item']) )
					{
						// Escape inputs and save values to variables defined before with empty value
						$title					= $mysqli->escape_string($_POST['title']);
						$url_key				= $mysqli->escape_string($_POST['url_key']);
						$content_tmp			= $_POST['content'];
						$meta_description_tmp	= $_POST['meta_description'];
						$category_id_tmp		= $_POST['category'];

						// If one of the required fields is empty, show alert
						if ( empty($_POST['title']) || empty($_POST['url_key']) || empty($_POST['content']) )
						{
							alert('warning', REQUIRED_FIELDS_EMPTY);
						}
						// If all required fields is not empty, continue
						else
						{
							// Match pages with this url_key and not the current page
							$query =
								"SELECT 
									post_id 
								FROM 
									posts 
								WHERE 
									post_url_key = '$url_key'
								AND 
									post_id != $id";
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

								// Update the post in the database
								$query =
									"UPDATE 
										posts 
									SET 
										post_url_key = '$url_key', post_title = '$title', post_content = '$content', post_meta_description = $meta_description, fk_category_id = $category
									WHERE 
										post_id = $id";
								$result = $mysqli->query($query);

								// If result returns false, use the function query_error to show debugging info
								if (!$result) query_error($query, __LINE__, __FILE__);

								// If posted tags is different from current tags, do this
								if (isset($_POST['tags']) && $_POST['tags'] != $tags)
								{
									// Overwrite $tags with new values
									$tags	= $_POST['tags'];

									// Delete old tags to avoid duplicates
									$query =
											"DELETE FROM
												posts_tags
											WHERE
												fk_post_id = $id";

									$result = $mysqli->query($query);

									// If result returns false, use the function query_error to show debugging info
									if (!$result) query_error($query, __LINE__, __FILE__);

									// If any tags was selected, do this
									if ( count($_POST['tags']) > 0 )
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
													($id, $tag_id)";
											$result = $mysqli->query($query);

											// If result returns false, use the function query_error to show debugging info
											if (!$result) query_error($query, __LINE__, __FILE__);
										}
									}
								}


								// Use function to insert event in log
								create_event('update', 'af blog-indlægget <a href="index.php?page=post-edit&id=' . $id . '" data-page="post-edit" data-params="id='. $id . '">' . $title . '</a>', $view_files[$view_file]['required_access_lvl']);

								alert('success', ITEM_UPDATED . ' <a href="index.php?page=posts" data-page="posts">' . RETURN_TO_OVERVIEW . '</a>');

								// If link_to_page is posted, create or update link to this post for the selected menus
								if ( isset($_POST['link_to_page']) )
								{
									// If link exist and either menus, link_name or page is changed, we use the update function
									if ( isset($link_id) && ( (isset($_POST['menus']) && $menus != $_POST['menus']) || $link_name != $_POST['link_name'] || $page_id != $_POST['page']) )
									{
										$menus		= $_POST['menus'];
										$link_name	= $mysqli->escape_string($_POST['link_name']);
										$page_id	= intval($_POST['page']);
										update_menu_link($menus, $link_id, $link_name, $page_id, 2, NULL, $id);
									}
									// If link_id is not defined, the link doesn't exist and we use the create function
									else if ( !isset($link_id) )
									{
										$menus		= isset($_POST['menus']) ? $_POST['menus'] : [];
										$link_name	= $mysqli->escape_string($_POST['link_name']);
										$page_id	= intval($_POST['page']);
										create_menu_link($menus, $link_name, $page_id, 2, NULL, $id);
									}
								}
								// If link_to_page is not posted, we have unchecked link to this post, so if link_id is defined, we use the delete function to delete it
								else if ( isset($link_id) )
								{
									delete_menu_link($link_id);
									$menus		= []; // reset selected menus
									$link_name	= ''; // reset link name
								}
							} // Closes else to: if ($result->num_rows > 0)
						} // Closes: ( empty($_POST['title']) || empty($_POST['url_key'])...
					} // Closes: if ( isset($_POST['save_item']) )
					include $include_path . 'form-post.php';
				} // Closes: if ($row->user_id == $_SESSION['user']['id'] || ...
				?>
			</form>
		</div>
	</div>
	<?php
}

show_developer_info();
