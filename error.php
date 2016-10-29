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

// Define variables used in nav
$page_url_key = $post_url_key = '';

// If status is defined in URL params, use te value from that, and if not, use default value 404
$status = isset($_GET['status']) ? $_GET['status'] : 404;

// Do switch on value from  $status
switch ($status)
{
	case 401:
	case 403:
		$title	= 'Webstedet afviste at vise denne webside';
		$text	= 'Ups!.. Noget gik galt. Du har ikke de nødvendige tilladelser som siden kræver.';
		break;
	case 500:
		$title	= 'Webstedet kan ikke vise siden';
		$text	= 'Ups!.. Noget gik galt. Et server-problem forhindrer visning af siden. Prøv evt. senere';
		break;
	case 400:
	case 404:
	default:
		$title	= 'Websiden blev ikke fundet';
		$text	= 'Ups!.. Noget gik galt. Siden du efterspurgte kunne ikke findes. Sørg for adressen er skrevet korrekt og prøv igen.';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">

    <title><?php echo 'HTTP ' . $status ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">

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

        <h1 class="page-header">
			<?php echo $title ?>
			<small><?php echo 'HTTP ' . $status ?></small>
		</h1>

		<p><?php echo $text ?></p>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="assets/jquery-2.2.4/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="assets/bootstrap-3.3.7/js/bootstrap.min.js"></script>

	<!-- Custom JavaScript -->
	<script src="js/app.js"></script>

</body>

</html>
<?php
ob_end_flush();
