<div class="form-group">
	<label for="menu"><?php echo MENUS ?>:</label><br>
	<?php
	// Get the menus from the database
	$query =
		"SELECT
			menu_id, menu_name
		FROM 
			menus 
		ORDER BY 
			menu_name";
	$result = $mysqli->query($query);

	// If result returns false, use the function query_error to show debugging info
	if (!$result) query_error($query, __LINE__, __FILE__);

	while( $row = $result->fetch_object() )
	{
		?>
		<div class="checkbox3 checkbox-inline checkbox-check checkbox-light">
			<input type="checkbox" name="menus[]" id="menu-<?php echo $row->menu_id ?>" <?php echo in_array($row->menu_id, $menus) ? 'checked' : '' ?> value="<?php echo $row->menu_id ?>">
			<label for="menu-<?php echo $row->menu_id ?>">
				<?php echo $row->menu_name ?>
			</label>
		</div>
		<?php
	}
	?>
</div>

<div class="form-group">
	<label for="name"><?php echo NAME ?>:</label>
	<input type="text" name="name" id="name" class="form-control" required maxlength="50" autofocus value="<?php echo $name ?>">
</div>

<div class="form-group">
	<label for="link_type"><?php echo TYPE ?>:</label>
	<select class="form-control" name="link_type" id="link_type">
		<?php
		// Get the menu link types from the database
		$query =
			"SELECT
				menu_link_type_id, menu_link_type_name
			FROM 
				menu_link_types";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		while( $row = $result->fetch_object() )
		{
			// If current value in $link_type matches the row from the database, add selected to the variable $selected
			$selected = $link_type == $row->menu_link_type_id ? ' selected' : '';

			echo '<option value="' . $row->menu_link_type_id . '"' . $selected . '>' . constant($row->menu_link_type_name) . '</option>';
		}
		?>
	</select>
</div>

<div class="form-group">
	<label for="page"><?php echo PAGE ?>:</label>
	<select class="form-control" name="page" id="page" required>
		<option value="" hidden><?php echo SELECT_AN_OPTION ?></option>
		<?php
		// Get the pages from the database
		$query =
			"SELECT
				page_id, page_title
			FROM 
				pages 
			ORDER BY 
				page_title";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		while( $row = $result->fetch_object() )
		{
			// If current value in $page matches the row from the database, add selected to the variable $selected
			$selected = $page == $row->page_id ? ' selected' : '';

			echo '<option value="' . $row->page_id . '"' . $selected . '>' . $row->page_title . '</option>';
		}
		?>
	</select>
</div>

<div class="form-group" id="2"<?php if ($link_type != 2) echo ' style="display: none"' ?>>
	<label for="post"><?php echo BLOG_POSTS ?>:</label>
	<select class="form-control select2" name="post" id="post"<?php if ($link_type == 2) echo ' required' ?>>
		<option value="" hidden><?php echo SELECT_AN_OPTION ?></option>
		<?php
		// Get the posts from the database
		$query =
			"SELECT
				post_id, post_title
			FROM 
				posts 
			ORDER BY 
				post_created DESC";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		while( $row = $result->fetch_object() )
		{
			// If current value in $post matches the row from the database, add selected to the variable $selected
			$selected = $post_tmp == $row->post_id ? ' selected' : '';

			echo '<option value="' . $row->post_id . '"' . $selected . '>' . $row->post_title . '</option>';
		}
		?>
	</select>
</div>

<div class="form-group" id="3"<?php if ($link_type != 3) echo ' style="display: none"' ?>>
	<label for="bookmark"><?php echo BOOKMARK_LABEL ?>:</label>
	<input class="form-control" type="text" name="bookmark" id="bookmark"<?php if ($link_type == 3) echo ' required' ?> pattern="([a-z0-9-.])+" title="<?php echo INVALID_URL_KEY ?>" value="<?php echo $bookmark_tmp ?>">
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>