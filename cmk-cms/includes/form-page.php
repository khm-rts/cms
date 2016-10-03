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
	<input type="text" name="url_key" id="url_key" class="form-control" required maxlength="50" pattern="([a-z0-9-.])+" title="<?php echo INVALID_URL_KEY ?>" value="">
</div>

<div class="form-group">
	<label for="meta_robots"><?php echo META_ROBOTS ?>:</label>
	<select class="form-control" name="meta_robots" id="meta_robots">
		<option value="noindex, follow"><?php echo META_ROBOTS_NOT_THIS ?></option>
		<option value="noindex, nofollow"><?php echo META_ROBOTS_NONE ?></option>
		<option value="index, follow"><?php echo META_ROBOTS_ALL ?></option>
		<option value="index, nofollow"><?php echo META_ROBOTS_ONLY_THIS ?></option>
	</select>
</div>

<div class="form-group">
	<label for="meta_description"><?php echo META_DESCRIPTION ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
	<textarea name="meta_description" id="meta_description" class="form-control" maxlength="155"></textarea>
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>