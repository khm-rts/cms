<?php
if ( !isset($view_files) )
{
	require '../config.php';
	$include_path = '../' . $include_path;
}
?>

<div class="page-title">
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['comment-edit']['icon'] . ' ' . $view_files['comment-edit']['title']
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
		<form method="post" data-page="comment-edit">
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo ITEM_UPDATED ?> <a href="index.php?page=comments&post-id=1" data-page="comments" data-params="post-id=1"><?php echo RETURN_TO_OVERVIEW ?></a>
			</div>

			<?php include $include_path . 'form-comment.php' ?>
		</form>
	</div>
</div>

<?php
if (DEVELOPER_STATUS) { show_developer_info(); }
