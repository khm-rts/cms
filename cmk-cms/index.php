<?php
ob_start();
require 'config.php';

// If user id or access level is not defined, or access level is below 10, throw the user away
if ( !isset($_SESSION['user']['id']) || !isset($_SESSION['user']['access_level']) || $_SESSION['user']['access_level'] < 10 )
{
	header('Location: ../');
	exit;
}

// If logout is defined in URL params, run function to logout
if ( isset($_GET['logout']) )
{
	logout();
	header('Location: login.php');
	exit;
}

// If page is set in URL params, save value to variable $view_file and if not save index to $view_file
$view_file = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 'index';

// Save path to files to include, with filename from value in $view_file
$view_path	= 'view/' . $view_file . '.php';

// Use title from $files Array, defined in include/config.php, with the key that matches the filename from $view_file
$view_title	= $view_files[$view_file]['title'] . ' - CMK Admin';
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $view_title ?></title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <!-- CSS Libs -->
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/animate.css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-switch-3.3.2/css/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/checkbox3/checkbox3.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/select2-4.0.3/css/select2.min.css">
    <!-- CSS App -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
	<link rel="stylesheet" type="text/css" href="../assets/google-code-prettify/prettify.css" />
	<script type="text/javascript" src="../assets/google-code-prettify/prettify.js"></script>

	<!-- CKEditor -->
	<script src="../assets/ckeditor-4.5.1/ckeditor.js"></script>
	<script>
		CKEDITOR.config.filebrowserBrowseUrl		= '../assets/kcfinder-3.12/browse.php?opener=ckeditor&type=files';
		CKEDITOR.config.filebrowserUploadUrl		= '../assets/kcfinder-3.12/upload.php?opener=ckeditor&type=files';
		CKEDITOR.config.filebrowserImageBrowseUrl	= '../assets/kcfinder-3.12/browse.php?opener=ckeditor&type=images';
		CKEDITOR.config.filebrowserImageUploadUrl	= '../assets/kcfinder-3.12/upload.php?opener=ckeditor&type=images';
		CKEDITOR.config.contentsCss					= ['../assets/bootstrap-3.3.7/css/bootstrap.min.css', '../css/ckeditor.css', '../assets/font-awesome-4.6.3/css/font-awesome.min.css']
	</script>
	<script>CKEDITOR.dtd.$removeEmpty['span'] = false;</script> <!-- Sikrer at tomme spans ikke fjernes i editor, da de bruges til font awesome ikoner -->
</head>

<body class="flat-blue" onload="prettyPrint()">
    <div class="app-container expanded">
        <div class="row content-container">
            <nav class="navbar navbar-default navbar-fixed-top navbar-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-expand-toggle">
                            <i class="fa fa-bars icon"></i>
                        </button>

						<ol class="breadcrumb navbar-breadcrumb" id="breadcrumb">
							<?php include 'includes/breadcrumb.php' ?>
                        </ol>

                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-th icon"></i>
                        </button>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                            <i class="fa fa-times icon"></i>
                        </button>
                        <li class="dropdown profile">
							<?php
							// Get the selected users id from the session
							$current_user_id = intval($_SESSION['user']['id']);
							// Get the user from the Database
							$query	=
								"SELECT 
									user_name, user_email 
								FROM 
									users 
								WHERE 
									user_id = $current_user_id";
							$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							// Return the information from the Database as an object
							$row	= $result->fetch_object();
							?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $row->user_name ?><span class="caret"></span></a>
                            <ul class="dropdown-menu animated fadeInDown">
                                <li>
                                    <div class="profile-info">
                                        <h4 class="username"><?php echo $row->user_name ?></h4>
                                        <p><?php echo $row->user_email ?></p>
                                        <div class="btn-group margin-bottom-2x" role="group">
											<a class="<?php echo $buttons['default'] ?>" href="index.php?page=user-edit"><?php echo $icons['edit'] . ' ' . EDIT_USER ?></a>
											<a class="<?php echo $buttons['default'] ?>" href="index.php?logout"><?php echo $icons['sign-out'] . ' ' . SIGN_OUT ?></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <?php include 'includes/side_menu.php' ?>

            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body" id="main-content" data-content="<?php echo $view_file ?>">
					<?php
					if ( file_exists($view_path) )
					{
						include $view_path;
					}
					else
					{
						header('Location: index.php?page=error&status=404');
						exit;
					}
					?>
                </div>

				<div class="loader-container text-center">
					<div><i class="fa fa-spinner fa-pulse fa-3x"></i></div>
					<div><?php echo LOADING ?>...</div>
				</div>
            </div>
        </div>
        <footer class="app-footer">
            <div class="wrapper">
                <span class="pull-right">Flat Admin v2.1.2 <a href="#"><i class="fa fa-long-arrow-up"></i></a></span> 2016 - Roskilde Tekniske Skole.
            </div>
        </footer>
		<!-- Javascript Libs -->
		<script type="text/javascript" src="../assets/jquery-2.2.4/jquery.min.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-confirmation/bootstrap-confirmation.min.js"></script>
		<script type="text/javascript" src="../assets/bootstrap-switch-3.3.2/js/bootstrap-switch.min.js"></script>
		<script type="text/javascript" src="../assets/jquery-match-height-0.7.0/jquery.matchHeight-min.js"></script>
		<script type="text/javascript" src="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script><!-- jQuery UI Sortable -->
		<script type="text/javascript" src="../assets/select2-4.0.3/js/select2.full.min.js"></script>
		<!-- Javascript -->
		<script type="text/javascript" src="js/app.js"></script>
</body>

</html>
<?php
ob_end_flush();
