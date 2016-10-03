<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo REQUIRED_FIELDS_EMPTY ?>
</div>

<div class="form-group">
	<label for="content"><?php echo CONTENT ?>:</label>
	<textarea name="content" id="content" autofocus></textarea>
	<script>
		CKEDITOR.replace('content', {
			toolbar: 'Basic'
		})
	</script>
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>