<div class="form-group">
	<label for="name"><?php echo NAME ?>:</label>
	<input type="text" name="name" id="name" class="form-control" required maxlength="50" autofocus value="<?php echo $name ?>">
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>