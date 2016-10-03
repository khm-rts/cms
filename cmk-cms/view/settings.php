<?php
if ( !isset($view_files) )
{
	require '../config.php';
}
?>

<div class="page-title">
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['settings']['icon'] . ' ' . $view_files['settings']['title']
		?>
	</span>
</div>

<div class="card">
	<div class="card-body">
		<form method="post" data-page="settings">
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo REQUIRED_FIELDS_EMPTY ?>
			</div>

			<div class="form-group">
				<label for="name"><?php echo NAME ?>:</label>
				<input type="text" name="name" id="name" class="form-control" required maxlength="100" autofocus value="">
			</div>

			<div class="form-group">
				<label for="company"><?php echo COMPANY ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
				<input type="text" name="company" id="company" class="form-control" maxlength="100" autofocus value="">
			</div>

			<div class="form-group">
				<label for="email"><?php echo EMAIL ?>:</label>
				<input type="email" name="email" id="email" class="form-control" required maxlength="100" value="">
			</div>

			<div class="form-group">
				<label for="phone"><?php echo PHONE ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
				<input type="number" name="phone" id="phone" class="form-control" value="">
			</div>

			<div class="form-group">
				<label for="street"><?php echo ADDRESS ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
				<input type="text" name="street" id="street" class="form-control" maxlength="255" value="">
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-3">
						<label for="zip"><?php echo ZIP ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
						<input type="number" name="zip" id="zip" class="form-control"value="">
					</div>
					<div class="col-md-9">
						<label for="city"><?php echo CITY ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
						<input type="text" name="city" id="city" class="form-control" maxlength="100" value="">
					</div>
				</div>
			</div>

			<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
				<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
			</button>
		</form>
	</div>
</div>

<?php
if (DEVELOPER_STATUS) { show_developer_info(); }
