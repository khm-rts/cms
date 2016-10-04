<?php
ob_start();
require 'config.php';

// If already sign in, go to index.php
if ( isset($_SESSION['user']['id']) )
{
	header('Location: index.php');
	exit;
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
    <title>Login - CMK Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <!-- CSS Libs -->
	<link rel="stylesheet" type="text/css" href="../assets/bootstrap-3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/font-awesome-4.6.3/css/font-awesome.min.css">
    <!-- CSS App -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">
	<link rel="stylesheet" type="text/css" href="../assets/google-code-prettify/prettify.css" />
	<script type="text/javascript" src="../assets/google-code-prettify/prettify.js"></script>
</head>

<body class="flat-blue login-page">
    <div class="container">
        <div class="login-box">
            <div>
                <div class="login-form row">
                    <div class="col-sm-12 text-center login-header">
                        <i class="login-logo fa fa-connectdevelop fa-5x"></i>
                        <h4 class="login-title">CMK Admin</h4>
                    </div>
                    <div class="col-sm-12">
                        <div class="login-body">
                            <div class="progress hidden" id="login-progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <?php echo SIGN_IN ?>
                                </div>
                            </div>
							<?php
							if ( isset($_POST['email']) )
							{
								if ( login($_POST['email'], $_POST['password']) )
								{
									header('Location: index.php');
									exit;
								}
							}
							?>
                            <form method="post">
                                <div class="control">
                                    <input type="email" name="email" class="form-control" placeholder="<?php echo EMAIL ?>" required value="">
                                </div>
                                <div class="control">
                                    <input type="password" name="password" class="form-control" placeholder="<?php echo PASSWORD ?>" required>
                                </div>
                                <div class="login-button text-center">
                                    <button type="submit" class="btn btn-primary"><?php echo $icons['sign-in'] . SIGN_IN ?></button>
                                </div>
                            </form>
                        </div>
                        <div class="login-footer">
                            <span class="text-right"><a href="#" class="color-white"></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php ob_end_flush();