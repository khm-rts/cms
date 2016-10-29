<?php
ob_start();
require 'config.php';

// If logout is defined in URL params, run function to logout
if ( isset($_GET['logout']) )
{
	logout();
	header('Location: index.php');
	exit;
}

// If page is set in URL params, save and escape value to variable $page_url_key and if not save empty value which matches home
$page_url_key = isset($_GET['page']) && !empty($_GET['page']) ? $mysqli->escape_string($_GET['page']) : '';

// Get active page from database where page url key match value in variable $page_url_key
$query =
	"SELECT
		page_id, page_title, page_meta_robots, page_meta_description
	FROM
		pages
	WHERE
		page_url_key = '$page_url_key'
	AND
		page_status = 1";
$result = $mysqli->query($query);

// If result returns false, use the function query_error to show debugging info
if (!$result) query_error($query, __LINE__, __FILE__);

// If no rows was found, the page doesn't exist in the database, so redirect the user to error page
if ($result->num_rows == 0)
{
	header('Location: error.php?status=404');
	exit;
}

// Save page information from the database into the variable $page
$page = $result->fetch_object();

// Default value for post url key
$post_url_key = '';

// If post is set in URL params, do this
if ( isset($_GET['post']) && !empty($_GET['post']) )
{
	// Save and escape value to variable $post_url_key
	$post_url_key = $mysqli->escape_string($_GET['post']);

	// Get active post from database where post url key match value in variable $post_url_key
	$query =
		"SELECT
			post_id, post_created, DATE_FORMAT(post_created, '%e. %M, %Y kl. %H:%i') AS post_created_formatted, post_title, post_content, post_meta_description, user_name, category_name, COUNT(comment_id) AS comments
		FROM
			posts
		INNER JOIN
			users ON posts.fk_user_id = users.user_id
		LEFT JOIN
			categories ON posts.fk_category_id = categories.category_id
		LEFT JOIN
			comments ON posts.post_id = comments.fk_post_id
		WHERE
			post_url_key = '$post_url_key'
		AND
			post_status = 1";
	$result = $mysqli->query($query);

	// If result returns false, use the function query_error to show debugging info
	if (!$result) query_error($query, __LINE__, __FILE__);

	// If no rows was found, the post doesn't exist in the database, so redirect the user to error page
	if ($result->num_rows == 0)
	{
		header('Location: error.php?status=404');
		exit;
	}

	// Save post information from the database into the variable $post
	$post = $result->fetch_object();
}

// Get settings
$query =
	"SELECT
		setting_person_name, setting_company_name, setting_email, setting_phone, setting_street, setting_zip, setting_city
	FROM
		settings
	WHERE
		setting_id = 1";
$result = $mysqli->query($query);

// If result returns false, use the function query_error to show debugging info
if (!$result) query_error($query, __LINE__, __FILE__);

// Save settings information from the database into the variable $settings
$settings = $result->fetch_object();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="<?php echo $page->page_meta_robots ?>">

	<?php
	// If $post is defined, we have selected a post from the database, so output meta data to this
	if ( isset($post) )
	{

	?><title><?php echo $post->post_title ?></title>
	<meta name="description" content="<?php echo $post->post_meta_description ?>">
	<meta property="og:title" content="<?php echo $post->post_title ?>">
	<meta property="og:type" content="article">
	<meta property="article:author" content="<?php echo $post->user_name ?>">
	<meta property="article:published_time" content="<?php echo date( 'c', strtotime($post->post_created) ) ?>">
	<?php

		if ( isset($post->category_name) )
		{
	?><meta property="article:section" content="<?php echo $post->category_name ?>">
	<?php
		}

		// Get the tags for the current post
		$query =
				"SELECT
					tag_name
				FROM
					posts_tags
				INNER JOIN
					tags ON posts_tags.fk_tag_id = tags.tag_id
				WHERE
					fk_post_id = " . $post->post_id;
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		$post_tags = []; // Empty array for the tags
		while( $row = $result->fetch_object() )
		{
			// Add tag to array
			$post_tags[] = $row->tag_name;
			// Output meta data for article tags
	?><meta property="article:tag" content="<?php echo $row->tag_name ?>">
	<?php
		}
	}
	// If $post is not defined, no post is selected, so show meta data to default pages
	else
	{
		?><title><?php echo $page->page_title ?></title>
	<meta name="description" content="<?php echo $page->page_meta_description ?>">
	<meta property="og:title" content="<?php echo $page->page_title ?>">
	<meta property="og:type" content="website">
	<meta property="og:description" content="<?php echo $page->page_meta_description ?>">
		<?php
	}
	?>

	<meta property="og:locale" content="da_DK">
	<meta property="og:site_name" content="<?php echo isset($settings->setting_company_name) ? $settings->setting_company_name : $settings->setting_person_name ?>">
	<meta property="og:url" content="http:<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">

	<!-- CSS Libs -->
	<link rel="stylesheet" type="text/css" href="assets/bootstrap-3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/font-awesome-4.6.3/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body data-spy="scroll">

    <!-- Navigation -->
    <?php include 'includes/main-nav.php' ?>

    <!-- Page Content -->
    <div class="container" id="main-content">

		<!-- Page Breadcrumb -->
		<ol class="breadcrumb">
			<?php
			// If $page_url_key is empty, we are on home page, so only show page title to this in nav
			if ($page_url_key == '')
			{
				// If $post is defined, we have selected a post from the database, so show these links
				if ( isset($post)  )
				{
					// Remove URL param post from current url
					$blog_url = str_replace('?post=' . $post_url_key, '', urldecode($_SERVER['REQUEST_URI']) );
					?>
					<li><a href="<?php echo $blog_url ?>"><?php echo $page->page_title ?></a></li>
					<li class="active"><?php echo $post->post_title ?></li>
					<?php
				}
				// If $post is not defined, no post is selected, so show this link
				else
				{
					?><li class="active">Forside</li><?php
				}
			}
			// If $page_url_key is not empty, show link to home page and selected page and post
			else
			{
				?><li><a href="./">Forside</a></li><?php

				// If $post is defined, we have selected a post from the database, so show these links
				if ( isset($post)  )
				{
					// Remove URL param post from current url
					$blog_url = str_replace('&post=' . $post_url_key, '', urldecode($_SERVER['REQUEST_URI']) );
					?>
					<li><a href="<?php echo $blog_url ?>"><?php echo $page->page_title ?></a></li>
					<li class="active"><?php echo $post->post_title ?></li>
					<?php
				}
				// If $post is not defined, no post is selected, so show this link
				else
				{
					?>
					<li class="active"><?php echo $page->page_title ?></li>
					<?php
				}
			}
			?>
		</ol>

        <div class="row">
			<?php
			// Get content for the current page
			$query =
					"SELECT
						page_content_type, page_content, page_layout_class, page_function_filename
					FROM
						page_content
					INNER JOIN
						page_layouts ON page_content.fk_page_layout_id = page_layouts.page_layout_id
					LEFT JOIN
						page_functions ON page_content.fk_page_function_id = page_functions.page_function_id
					WHERE
						fk_page_id = " . $page->page_id . "
					ORDER BY
						page_content_order";
			$result_page_content = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result_page_content) query_error($query, __LINE__, __FILE__);

			// Loop through the content from the database
			while( $page_content = $result_page_content->fetch_object() )
			{
				// Create container to content with the layout assigned to the page content
				echo '<div class="' . $page_content->page_layout_class . '">';

				// If content type is 1 (text editor), use echo to display content
				if ($page_content->page_content_type == 1)
				{
					echo $page_content->page_content;
				}
				// If content type is 2 (page function), use include to display content from file
				else
				{
					// Save path to file
					$file_path = 'page-functions/' . $page_content->page_function_filename;

					// If the file is found in path, include it
					if ( file_exists($file_path) ) include $file_path;
				}

				echo '</div>';
			}
			?>
		</div>
        <!-- /.row -->

		<?php
		show_developer_info()
		?>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <h4>Sider</h4>
					<ul class="list-unstyled">
						<?php
						// Use function to get links for footer which has menu id: 2
						get_menu_links(2, $page_url_key, $post_url_key);
						?>
					</ul>
                </div>
                <!-- /.col-md-3 .col-sm-6 -->

				<div class="col-md-3 col-sm-6">
					<h4>Mine sider</h4>
					<ul class="list-unstyled">
						<?php
						// If a user is logged in, display his name link to edit profile and link to sign out
						if ( isset($_SESSION['user']['id']) )
						{
							?>
							<li>
								<a href="index.php?page=ny-profil"><i class="fa fa-fw fa-edit"></i> Rediger profil</a>
							</li>
							<li>
								<a href="index.php?logout"><i class="fa fa-fw fa-power-off"></i> Log af</a>
							</li>
							<?php
						}
						// If no user is signed in, display link to modal where he can sign in and link to create new profile
						else
						{
							?>
							<li>
								<a href="#" data-toggle="modal" data-target="#loginModal"><i class="fa fa-fw fa-sign-in"></i>  Log på</a>
							</li>
							<li>
								<a href="index.php"><i class="fa fa-fw fa-plus"></i> Ny profil</a>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
				<!-- /.col-md-3 .col-sm-6 -->

				<div class="col-md-3 col-sm-6">
					<h4>Hvor finder du os?</h4>

					<p><strong><?php echo isset($settings->setting_company_name) ? $settings->setting_company_name : $settings->setting_person_name ?></strong>
						<?php if (isset($settings->setting_street) ) echo '<br>' . $settings->setting_street ?>
						<?php if (isset($settings->setting_zip, $settings->setting_city) ) echo '<br>' . $settings->setting_zip . ' ' . $settings->setting_city ?>
					</p>
				</div>
				<!-- /.col-md-3 .col-sm-6 -->

				<div class="col-md-3 col-sm-6">
					<h4>Kontakt os</h4>

					<p>
						E-mailadresse: <a href="mailto:<?php echo $settings->setting_email ?>"><?php echo $settings->setting_email ?></a>
						<?php if (isset($settings->setting_phone) ) echo '<br>Telefon: ' . $settings->setting_phone ?>
					</p>

					<a href="index.php?page=kontakt">Gå til kontaktside</a>
				</div>
				<!-- /.col-md-3 .col-sm-6 -->
            </div>
            <!-- /.row -->
        </footer>

		<hr>

		<div id="copyright">
			<p>Copyright &copy; Your Website 2014</p>
		</div>

    </div>
    <!-- /.container -->

	<?php include 'includes/modal_login.php'; ?>

    <!-- jQuery -->
    <script src="assets/jquery-2.2.4/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="assets/jquery-match-height-0.7.0/jquery.matchHeight-min.js"></script>
	<script>
		<?php
		// If login_status is defined and is false, show modal so alerts inside is visible
		if ( isset($login_status) && !$login_status ) echo "$('#loginModal').modal('show');";
		?>
	</script>

	<!-- Custom JavaScript -->
	<script src="js/app.js"></script>

</body>

</html>
<?php
ob_end_flush();
