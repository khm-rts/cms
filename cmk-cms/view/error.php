<?php
if ( !isset($view_files) )
{
	require '../config.php';
}

if ( isset($_GET['status']) )
{
	$status = $_GET['status'];

	switch ($status) {
		case 400:
			$title	= PAGE_NOT_FOUND;
			$text	= PAGE_NOT_FOUND_DESCR;
			break;
		case 401:
			$title	= PAGE_DENIED;
			$text	= PAGE_DENIED_DESCR;
			break;
		case 403:
			$title	= PAGE_DENIED;
			$text	= PAGE_DENIED_DESCR;
			break;
		case 404:
			$title	= PAGE_NOT_FOUND;
			$text	= PAGE_NOT_FOUND_DESCR;
			break;
		case 500:
			$title	= PAGE_ERROR;
			$text	= PAGE_ERROR_DESCR;
			break;
	}
}
else
{
	$status	= 404;
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