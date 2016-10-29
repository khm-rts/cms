<?php
// Define variables with empty values
$search	= $search_url = $search_sql = $user = $user_url	= $user_sql	= $category	= $category_url	= $category_csv = $category_sql = $tag = $tag_url = $tag_csv = $tag_sql = '';

// Define variables with empty array
$users = $categories = $tags = [];

$current_url = $_SERVER['REQUEST_URI'];

// If session $page_url_key is not defined, define it with empty array
if ( !isset($_SESSION[$page_url_key]) )	$_SESSION[$page_url_key]		= [];

// If page-no is defined in URL params and the value is not empty, save the value to $page_no or use default value: 1
$page_no = isset($_GET['page-no']) && !empty($_GET['page-no']) ? intval($_GET['page-no']) : 1;

// If search is defined in URL params and the value is not empty, save the value to variable
if ( isset($_GET['search']) && !empty($_GET['search']) )
{
	// Escape value from URL param search and save to variable
	$search			= $mysqli->escape_string($_GET['search']);
	$search_url		= '&search=' . $search;
	$search_sql		=
			"
			AND 
				(post_title LIKE '%$search%' 
			OR 
				post_content LIKE '%$search%'
			OR
				user_name LIKE '%$search%')";
	// Search limits the result and therefor the amount of pages, so clear current page from url
	$page_no_url	= '';
}

// If user is defined in URL params and the value is not empty, save the value to session
if ( isset($_GET['user']) && !empty($_GET['user']) )
{
	// Escape value from URL param user and save to variable
	$user			= $mysqli->escape_string($_GET['user']);
	// Convert CSV to array
	$users			= explode(',', $user);
	$user_url		= '&user=' . $user;
	// Add quotes between each value in CSV $user
	$user_csv	= str_replace(",", "','", $user);
	// SQL part thats limits posts to matching users in $user_csv
	$user_sql		=
			"
			AND 
				user_name IN ('$user_csv')";
	// User limits the result and therefor the amount of pages, so clear current page from url
	$page_no_url	= '';
}

// If category is defined in URL params and the value is not empty, save the value to session
if ( isset($_GET['category']) && !empty($_GET['category']) )
{
	// Escape value from URL param category and save to variable
	$category		= $mysqli->escape_string($_GET['category']);
	// Convert CSV to array
	$categories		= explode(',', $category);
	$category_url	= '&category=' . $category;
	// Add quotes between each value in CSV $category
	$category_csv	= str_replace(",", "','", $category);
	// SQL part thats limits posts to matching categories in $category_csv
	$category_sql	=
			"
			INNER JOIN
				categories ON posts.fk_category_id = categories.category_id
			AND
				category_name IN ('$category_csv')";
	// Category limits the result and therefor the amount of pages, so clear current page from url
	$page_no_url	= '';
}

// If tag is defined in URL params and the value is not empty, save the value to session
if ( isset($_GET['tag']) && !empty($_GET['tag']) )
{
	// Escape value from URL param tag and save to variable
	$tag			= $mysqli->escape_string($_GET['tag']);
	// Convert CSV of tags to array
	$tags			= explode(',', $tag);
	$tag_url		= '&tag=' . $tag;
	// Add quotes between each value in CSV $category
	$tag_csv		= str_replace(",", "','", $tag);
	// SQL part thats limits posts to matching tags in $tag_csv
	$tag_sql		=
			"
			INNER JOIN
				posts_tags ON posts.post_id = posts_tags.fk_post_id
			INNER JOIN
				tags ON posts_tags.fk_tag_id = tags.tag_id
			AND
				tag_name IN ('$tag_csv')";
	// Tag limits the result and therefor the amount of pages, so clear current page from url
	$page_no_url	= '';
}

// If clear is defined in URL params and the value is not empty, do this
if ( isset($_GET['clear']) && !empty($_GET['clear']) )
{
	switch($_GET['clear'])
	{
		case 'search':
			// Use str_replace, to remove $search_url from the current URL and save to the variable $new_url
			$new_url = str_replace( $search_url, '', urldecode($current_url) );
			break;

		case 'user':
			// Remove value from array $users if it exists
			if ( ($key = array_search($_GET['value'], $users) ) !== false ) unset($users[$key]);

			// Remove URL param value from current url
			$new_url = str_replace('&value=' . $_GET['value'], '', urldecode($current_url) );

			// If there's any items left in $users, comma seperate them and append them to URL param user. If there's no items left, save empty value
			$new_user_url = count($users) > 0 ? '&user=' . implode(',', $users) : '';

			// Replace old users with new users and overwrite $new_url
			$new_url = str_replace($user_url, $new_user_url, $new_url );

			break;

		case 'category':
			// Remove value from array $categories if it exists
			if ( ($key = array_search($_GET['value'], $categories) ) !== false ) unset($categories[$key]);

			// Remove URL param value from current url
			$new_url = str_replace('&value=' . $_GET['value'], '', urldecode($current_url) );

			// If there's any items left in $categories, comma seperate them and append them to URL param category. If there's no items left, save empty value
			$new_category_url = count($categories) > 0 ? '&category=' . implode(',', $categories) : '';

			// Replace old categories with news categories and overwrite $new_url
			$new_url = str_replace($category_url, $new_category_url, $new_url );

			break;

		case 'tag':
			// Remove value from array $tags if it exists
			if ( ($key = array_search($_GET['value'], $tags) ) !== false ) unset($tags[$key]);

			// Remove URL param value from current url
			$new_url = str_replace('&value=' . $_GET['value'], '', urldecode($current_url) );

			// If there's any items left in $tags, comma seperate them and append them to URL param tag. If there's no items left, save empty value
			$new_tag_url = count($tags) > 0 ? '&tag=' . implode(',', $tags) : '';

			// Replace old tags with news tags and overwrite $new_url
			$new_url = str_replace($tag_url, $new_tag_url, $new_url );

			break;
	}
	// Use str_replace, to remove the clear param from $new_url and refresh the page to this URL
	header( 'Location: ' . str_replace('&clear=' . $_GET['clear'], '', $new_url) );
	// Each of these limits the result and therefor the amount of pages, so clear current page from url
	$page_no_url = '';
}
?>
<div class="row">
	<!-- Blog Entries Column -->
	<article class="col-md-8">
		<?php
		// If $post is defined, we have selected a post from the database, so display information from $post, defined on index.php
		if ( isset($post) )
		{
			?>
			<!-- Title -->
			<h1>
				<?php echo $post->post_title ?>
				<?php if ( isset($post->category_name) ) echo '<small>' . $post->category_name . '</small>' ?>
			</h1>

			<ul class="list-inline text-muted">
				<!-- Author -->
				<li>
					<?php
					// If this user name is not in the value from the URL parameter user, do this
					if ( !in_array($post->user_name, $users) )
					{
						// Assign this user name to the variable $user_value
						$user_value = $post->user_name;
						// If the value from the URL paramerer user is not empty, we need to prefix the new value, with the existing one plus a comma
						if ( !empty($user) ) $user_value = $user . ',' . $user_value;
					}
					// If this user name is in the value from the URL parameter user, do this
					else
					{
						// Assign the existing value from the URL parameter user to the variable $user_value
						$user_value = $user;
					}
					?>
					<i class="fa fa-user fa-fw" aria-hidden="true"></i> af <a href="index.php?page=<?php echo $page_url_key . $search_url . $category_url . $tag_url ?>&user=<?php echo $user_value ?>"><?php echo $post->user_name ?></a>
				</li>

				<!-- Tags -->
				<?php
				// If any tags is assigned to the article, show them here
				if ( count($post_tags) > 0)
				{
					echo '<li>';
					echo '<i class="fa fa-tags fa-fw" aria-hidden="true"></i> ';
					$post_tag_links = [];
					// Loop through the array $post_tags to append link to array $post_tag_links for each tag related to the post
					foreach ($post_tags as $post_tag)
					{
						// If this tag name is not in the value from the URL parameter tag, do this
						if ( !in_array($post_tag, $tags) )
						{
							// Assign this tag name to the variable $tag_value
							$tag_value = $post_tag;
							// If the value from the URL paramerer tag is not empty, we need to prefix the new value, with the existing one plus a comma
							if ( !empty($tag) ) $tag_value = $tag . ',' . $tag_value;
						}
						// If the tag name is in the value from the URL parameter tag, do this
						else
						{
							// Assign the existing value from the URL parameter tag to the variable $tag_value
							$tag_value = $tag;
						}

						$post_tag_links[] = '<a href="index.php?page=' . $page_url_key . $search_url . $user_url . $category_url . '&tag=' . $tag_value . '">' . $post_tag . '</a>';
					}
					// Use implode on array $post_tag_links to show tags comma seperated
					echo implode(', ', $post_tag_links);
					echo '</li>';
				}
				?>

				<!-- Date/Time -->
				<li>
					<i class="fa fa-clock-o fa-fw" aria-hidden="true"></i> Oprettet d. <?php echo $post->post_created_formatted ?>
				</li>

				<li>
					<i class="fa fa-comments aria-hidden="true"></i> <?php echo $post->comments ?>
				</li>
			</ul>

			<hr>

			<!-- Post Content -->
			<?php echo $post->post_content ?>

			<hr>

			<!-- Blog Comments -->

			<!-- Comments Form -->
			<div class="well">
				<h4><i class="fa fa-comment" aria-hidden="true"></i> Smid en kommentar:</h4>
				<?php
				// If comment has been submitted
				if ( isset($_POST['content']) )
				{
					// If content was empty, show this message
					if ( empty($_POST['content']) )
					{
						alert('warning', 'Kommentarfeltet var tomt');
					}
					else
					{
						// Escape and save the value to this variable
						$content	= $mysqli->escape_string($_POST['content']);
						// Get the users id from session and secure the value is a number
						$user_id	= intval($_SESSION['user']['id']);

						// Insert the comment into the database
						$query =
								"INSERT INTO
									comments (comment_content, fk_user_id, fk_post_id)
								VALUES
									('$content', $user_id, " . $post->post_id . ")";
						$result = $mysqli->query($query);
					}

				}
				?>
				<form id="add_comment" method="post" role="form">
					<div class="form-group">
						<textarea class="form-control" id="content" name="content" rows="3" title="Skriv kommentar her"></textarea>

						<!-- CKEditor -->
						<script src="assets/ckeditor-4.5.1/ckeditor.js"></script>
						<script>
							CKEDITOR.config.filebrowserBrowseUrl		= 'assets/kcfinder-3.12/browse.php?opener=ckeditor&type=files';
							CKEDITOR.config.filebrowserUploadUrl		= 'assets/kcfinder-3.12/upload.php?opener=ckeditor&type=files';
							CKEDITOR.config.filebrowserImageBrowseUrl	= 'assets/kcfinder-3.12/browse.php?opener=ckeditor&type=images';
							CKEDITOR.config.filebrowserImageUploadUrl	= 'assets/kcfinder-3.12/upload.php?opener=ckeditor&type=images';
							CKEDITOR.config.contentsCss					= ['assets/bootstrap-3.3.7/css/bootstrap.min.css', 'css/ckeditor.css', 'assets/font-awesome-4.6.3/css/font-awesome.min.css'];

							CKEDITOR.replace('content', {
								height: 75,
								toolbar: 'Basic'
							})
						</script>
					</div>
					<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Slå op</button>
				</form>
			</div>

			<hr>

			<!-- Posted Comments -->
			<div id="comments">
				<?php
				// Get all comments to this post from the database
				$query =
						"SELECT
							DATE_FORMAT(comment_created, '%e. %M, %Y kl. %H:%i') AS comment_created_formatted,
							comment_content, user_name
						FROM
							comments
						INNER JOIN
							users ON comments.fk_user_id = users.user_id
						WHERE
							fk_post_id = " . $post->post_id . "
						ORDER BY
							comment_created";
						$result = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);

				// If any rows was found, show the comments
				if ($result->num_rows > 0)
				{
					// Save comment information from the database into the variable $row
					while( $row = $result->fetch_object() )
					{
						?>
						<div class="media">
							<div class="media-body">
								<h4 class="media-heading">
									<i class="fa fa-user fa-fw" aria-hidden="true"></i> <?php echo $row->user_name ?>
									<small><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i> <?php echo $row->comment_created_formatted ?></small>
								</h4>
								<?php echo $row->comment_content ?>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
			<!-- /#comments -->
			<?php
		} // Close: if ( isset($post) )
		// If no post is defined in URL params, display list of all posts from the database
		else
		{
			// Default items per page.
			$page_length	= 10;

			// Get active posts from database
			$query	=
					"SELECT 
						post_id, DATE_FORMAT(post_created, '%e. %M, %Y kl. %H:%i') AS post_created_formatted, post_url_key, post_title, post_content, user_name, COUNT(comment_id) AS comments
					FROM 
						posts
					INNER JOIN
						users ON posts.fk_user_id = users.user_id
					LEFT JOIN
						comments ON posts.post_id = comments.fk_post_id $category_sql $tag_sql
					WHERE
						post_status = 1 $search_sql $user_sql";
			$result	= $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			$items_total = $result->num_rows;

			$offset = ($page_no - 1) * $page_length;

			$query .=
					"
					GROUP BY
						post_id
					ORDER BY 
						post_created DESC
					LIMIT 
						$page_length
					OFFSET 
						$offset";

			$result	= $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			$items_current_total = $result->num_rows;

			while( $row = $result->fetch_object() )
			{
				$url = 'index.php?page=' . $page_url_key . $search_url . $user_url . $category_url . $tag_url . '&post=' . $row->post_url_key;
				?>
				<section id="post-<?php echo $row->post_id ?>">
					<!-- Title -->
					<h2>
						<a href="<?php echo $url ?>"><?php echo $row->post_title ?></a>
					</h2>

					<ul class="list-inline text-muted">
						<!-- Author -->
						<li>
							<?php
							// If this user name is not in the value from the URL parameter user, do this
							if ( !in_array($row->user_name, $users) )
							{
								// Assign this user name to the variable $user_value
								$user_value = $row->user_name;
								// If the value from the URL paramerer user is not empty, we need to prefix the new value, with the existing one plus a comma
								if ( !empty($user) ) $user_value = $user . ',' . $user_value;
							}
							// If this user name is in the value from the URL parameter user, do this
							else
							{
								// Assign the existing value from the URL parameter user to the variable $user_value
								$user_value = $user;
							}

							?>
							<i class="fa fa-user fa-fw" aria-hidden="true"></i> af <a href="index.php?page=<?php echo $page_url_key . $search_url . $category_url . $tag_url ?>&user=<?php echo $user_value ?>"><?php echo $row->user_name ?></a>
						</li>

						<!-- Date/Time -->
						<li>
							<i class="fa fa-clock-o" aria-hidden="true"></i> Oprettet d. <?php echo $row->post_created_formatted ?>
						</li>

						<li>
							<i class="fa fa-comments aria-hidden="true"></i> <?php echo $row->comments ?>
						</li>
					</ul>

					<hr>

					<!-- Post Content -->
					<p><?php echo shorten_string($row->post_content, 360) // Use function to show max 100 characters of the post content ?></p>

					<a class="btn btn-primary" href="<?php echo $url ?>">Læs mere <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i></a>
					<hr>
				</section>
				<?php
			} // Close: while( $row...

			pagination($page_url_key . $search_url . $user_url . $category_url . $tag_url, $page_no, $items_total, $page_length);
		} // Close else to: if ( isset($post) )
		?>
	</article>
	<!-- /.col-md-8 -->

	<!-- Blog Sidebar Widgets Column -->
	<div class="col-md-4">

		<!-- Blog Search Well -->
		<form class="well">
			<input type="hidden" name="page" value="<?php echo $page_url_key ?>">
			<h4>Filtre</h4>
			<div class="form-group">
				<div class="input-group">
				<span class="input-group-btn">
					<button class="btn btn-default" title="Søg" type="submit">
						<i class="fa fa-search fa-fw" aria-hidden="true"></i>
					</button>
				</span>
					<input class="form-control" name="search" placeholder="Fritekst søgning..." type="search" value="<?php echo $search ?>">
					<?php if ( !empty($search) ) { // Only show clear link if search is not empty ?>
						<span class="input-group-btn">
					<a class="btn btn-default" href="<?php echo $_SERVER['REQUEST_URI'] ?>&clear=search" title="Ryd">
						<i class="fa fa-times fa-fw" aria-hidden="true"></i>
					</a>
				</span>
					<?php } ?>
				</div>
			</div>

			<!-- /.input-group -->

			<?php
			// If $user is not empty, output hidden field and show value and clear link for this
			if ( !empty($user) )
			{
				echo '<input type="hidden" name="user" value="' . $user . '">';

				// Output link for each user in array
				foreach ($users as $value)
				{
					echo '<a class="tag label label-info" href="' . $current_url . '&clear=user&value=' . $value . '" title="Fjern filter">' . $value . ' <i class="fa fa-times" aria-hidden="true"></i></a> ';
				}
			}

			// If $category is not empty, output hidden field and show filter and clear link for this
			if ( !empty($category) )
			{
				echo '<input type="hidden" name="category" value="' . $category . '">';

				// Output link for each category in array
				foreach ($categories as $value)
				{
					echo '<a class="tag label label-default" href="' . $current_url . '&clear=category&value=' . $value . '" title="Fjern filter">' . $value . ' <i class="fa fa-times" aria-hidden="true"></i></a> ';
				}
			}

			// If $tag is not empty, output hidden field and show filter and clear link for this
			if ( !empty($tag) )
			{
				echo '<input type="hidden" name="tag" value="' . $tag . '">';

				// Output link for each tag in array
				foreach ($tags as $value)
				{
					echo '<a class="tag label label-primary" href="' . $current_url . '&clear=tag&value=' . $value . '" title="Fjern filter">' . $value . ' <i class="fa fa-times" aria-hidden="true"></i></a> ';
				}

			}
			?>

		</form>

		<!-- Blog Categories Well -->
		<?php
		// Get all categories related to a post from the database, which is not already selected
		$query =
				"SELECT
					category_name
				FROM
					categories
				INNER JOIN
					posts ON categories.category_id = posts.fk_category_id
				GROUP BY
					category_id";
		$result	= $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		// Only show this well of there's any categories
		if ($result->num_rows > 0)
		{
			?>
			<div class="well">
				<h4>Kategorier</h4>
				<?php
				$categories_tmp = [];
				// Save category information from the database into the variable $row
				while( $row = $result->fetch_object() )
				{
					// If this category name is not in the value from the URL parameter category, do this
					if ( !in_array($row->category_name, $categories) )
					{
						// Assign this category name to the variable $category_value
						$category_value = $row->category_name;
						// If the value from the URL paramerer category is not empty, we need to prefix the new value, with the existing one plus a comma
						if ( !empty($category) ) $category_value = $category . ',' . $category_value;
					}
					// If the category name is in the value from the URL parameter category, do this
					else
					{
						// Assign the existing value from the URL parameter category to the variable $category_value
						$category_value = $category;
					}

					// If the current category is equal to the category in the post beeing viewed
					$lead = isset($post->category_name) && $post->category_name == $row->category_name ? ' class="lead"' : '';

					echo '<a' . $lead . ' href="index.php?page=' . $page_url_key . $search_url . $user_url . $tag_url . '&category=' . $category_value . '">' . $row->category_name . '</a> ';
				}
				?>
			</div>
			<?php
		}
		?>

		<!-- Side Widget Well -->
		<?php

		// Get all tags related to a post from the database, which is not already selected
		$query =
				"SELECT
					tag_name
				FROM
					tags
				INNER JOIN
					posts_tags ON tags.tag_id = posts_tags.fk_tag_id
				GROUP BY
					tag_id";
		$result	= $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		// Only show this well of there's any categories
		if ($result->num_rows > 0)
		{
			?>
			<div class="well">
				<h4>Tags</h4>
				<?php
				// Save category information from the database into the variable $row
				while( $row = $result->fetch_object() )
				{
					// If this tag name is not in the value from the URL parameter tag, do this
					if ( !in_array($row->tag_name, $tags) )
					{
						// Assign this tag name to the variable $tag_value
						$tag_value = $row->tag_name;
						// If the value from the URL paramerer tag is not empty, we need to prefix the new value, with the existing one plus a comma
						if ( !empty($tag) ) $tag_value = $tag . ',' . $tag_value;
					}
					// If the tag name is in the value from the URL parameter tag, do this
					else
					{
						// Assign the existing value from the URL parameter tag to the variable $tag_value
						$tag_value = $tag;
					}

					// If the current tag is used in the post beeing viewed
					$lead = isset($post_tags) && in_array($row->tag_name, $post_tags) ? ' class="lead"' : '';

					echo '<a' . $lead . ' href="index.php?page=' . $page_url_key . $search_url . $user_url . $category_url . '&tag=' . $tag_value . '">' . $row->tag_name . '</a> ';
				}
				?>
			</div>
			<?php
		}
		?>

	</div>
	<!-- /.col-md-4 -->
</div>
