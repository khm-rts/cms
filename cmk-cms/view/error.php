<?php
if ( !isset($view_files) ) require '../config.php';

// If status is defined in URL params, use te value from that, and if not, use default value 404
$status = isset($_GET['status']) ? $_GET['status'] : 404;

// Do switch on value from  $status
switch ($status)
{
	case 401:
	case 403:
		$title	= PAGE_DENIED;
		$text	= PAGE_DENIED_DESCR;
		break;
	case 500:
		$title	= PAGE_ERROR;
		$text	= PAGE_ERROR_DESCR;
		break;
	case 400:
	case 404:
	default:
		$title	= PAGE_NOT_FOUND;
		$text	= PAGE_NOT_FOUND_DESCR;
}
?>
<div class="page-title">
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['error']['icon'] . ' ' . $title
		?>
	</span>
	<div class="description"><?php echo 'HTTP ' . $status ?></div>
</div>

<p><?php echo $text ?></p>