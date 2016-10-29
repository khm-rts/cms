<div class="form-group">
	<label for="name"><?php echo NAME ?>:</label>
	<input type="text" name="name" id="name" class="form-control" required maxlength="50" autofocus value="<?php echo $name ?>">
</div>

<div class="form-group">
	<label for="url_key"><?php echo URL_KEY ?>:</label>
	<input type="text" name="url_key" id="url_key" class="form-control" maxlength="50" pattern="([a-z0-9-.])+" title="<?php echo INVALID_URL_KEY ?>" value="<?php echo $url_key ?>">
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>