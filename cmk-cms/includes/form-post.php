<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo REQUIRED_FIELDS_EMPTY ?>
</div>

<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo URL_NOT_AVAILABLE ?>
</div>

<div class="form-group">
	<label for="title"><?php echo TITLE ?>:</label>
	<input type="text" name="title" id="title" class="form-control" required maxlength="55" autofocus value="">
</div>

<div class="form-group">
	<label for="url_key"><?php echo URL_KEY ?>:</label>
	<input type="text" name="url_key" id="url_key" class="form-control" required maxlength="55" pattern="([a-z0-9-.])+" title="<?php echo INVALID_URL_KEY ?>" value="">
</div>

<div class="form-group">
	<label for="content"><?php echo CONTENT ?>:</label>
	<textarea name="content" id="content"></textarea>
	<script>
		CKEDITOR.replace('content', {
			toolbar: 'Full'
		})
	</script>
</div>

<div class="form-group">
	<label for="meta_description"><?php echo META_DESCRIPTION ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
	<textarea name="meta_description" id="meta_description" class="form-control" maxlength="155"></textarea>
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>