<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo REQUIRED_FIELDS_EMPTY ?>
</div>

<div class="form-group">
	<label for="content_type"><?php echo TYPE ?>:</label>
	<select class="form-control" name="content_type" id="content_type">
		<option value="1" selected><?php echo EDITOR ?></option>
		<option value="2"><?php echo PAGE_FUNCTION ?></option>
	</select>
</div>

<div id="1">
	<div class="form-group">
		<label for="description"><?php echo DESCRIPTION ?>:</label>
		<input type="text" name="description" id="description" class="form-control" required maxlength="255" value="">
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
</div>

<div class="form-group" id="2" style="display: none">
	<label for="page_function"><?php echo PAGE_FUNCTION ?>:</label>
	<select class="form-control" name="page_function" id="page_function">
		<option value="1">Blog: Oversigt over indlæg</option>
		<option value="2">Kontaktformular</option>
	</select>
</div>

<div class="form-group">
	<label for="layout"><?php echo LAYOUT ?>:</label>
	<select class="form-control" name="layout" id="layout">
		<option value="1"><?php echo COLUMN ?>: 100%</option>
		<option value="2"><?php echo COLUMN ?>: 75%</option>
		<option value="3"><?php echo COLUMN ?>: 66%</option>
		<option value="4"><?php echo COLUMN ?>: 50%</option>
		<option value="5"><?php echo COLUMN ?>: 33%</option>
		<option value="6"><?php echo COLUMN ?>: 25%</option>
	</select>
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>