<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<?php echo REQUIRED_FIELDS_EMPTY ?>
</div>

<div class="form-group">
	<label for="name"><?php echo NAME ?>:</label>
	<input type="text" name="name" id="name" class="form-control" required maxlength="55" autofocus value="">
</div>

<div class="form-group">
	<label for="content_type"><?php echo TYPE ?>:</label>
	<select class="form-control" name="link_type" id="link_type">
		<option value="1" selected><?php echo PAGE ?></option>
		<option value="2"><?php echo BLOG_POSTS ?></option>
	</select>
</div>

<div class="form-group">
	<label for="page"><?php echo PAGE ?>:</label>
	<select class="form-control" name="page" id="page" required>
		<option value=""><?php echo SELECT_AN_OPTION ?></option>
		<option value="1">Forside</option>
		<option value="2">Blog</option>
		<option value="3">Kontakt</option>
	</select>
</div>

<div class="form-group" id="2" style="display: none">
	<label for="post"><?php echo BLOG_POSTS ?>:</label>
	<select class="form-control" name="post" id="post">
		<option value=""><?php echo SELECT_AN_OPTION ?></option>
		<option value="1">Eksempel på indlæg 1</option>
		<option value="2">Eksempel på indlæg 2</option>
	</select>
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>