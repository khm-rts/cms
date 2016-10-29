<div class="form-group">
	<label for="title"><?php echo TITLE ?>:</label>
	<input type="text" name="title" id="title" class="form-control" required maxlength="55" autofocus value="<?php echo $title ?>">
</div>

<div class="form-group">
	<label for="url_key"><?php echo URL_KEY ?>:</label>
	<input type="text" name="url_key" id="url_key" class="form-control" maxlength="50" pattern="([a-z0-9-.])+" title="<?php echo INVALID_URL_KEY ?>" value="<?php echo $url_key ?>">
</div>

<div class="form-group">
	<label for="meta_robots"><?php echo META_ROBOTS ?>:</label>
	<select class="form-control" name="meta_robots" id="meta_robots" required>
		<?php
		$options =
		[
			'noindex, follow'	=> META_ROBOTS_NOT_THIS,
			'noindex, nofollow'	=> META_ROBOTS_NONE,
			'index, follow'		=> META_ROBOTS_ALL,
			'index, nofollow'	=> META_ROBOTS_ONLY_THIS
		];

		// Run foreach-loop on the array options, defined above
		foreach($options as $key => $value)
		{
			// If the value from $meta_robots matches the current key, save selected to the variable $selected and if not, save empty string
			$selected = $meta_robots == $key ? ' selected' : '';

			// Output option for each item from the array $options
			echo '<option value="' . $key . '"' . $selected .'>' . $value . '</option>';
		}
		?>
	</select>
</div>

<div class="form-group">
	<label for="meta_description"><?php echo META_DESCRIPTION ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
	<textarea name="meta_description" id="meta_description" class="form-control" maxlength="155"><?php echo $meta_description_tmp ?></textarea>
</div>

<div class="checkbox3 checkbox-check checkbox-light">
	<input type="checkbox" name="link_to_page" id="link_to_page"<?php if ( count($menus) > 0 ) echo ' checked' ?>>
	<label for="link_to_page">
		<?php echo LINK_TO_ELEMENT ?>
	</label>
</div>

<div id="menu_link"<?php if ( count($menus) == 0 ) echo ' style="display: none"' ?>>
	<hr>
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
		<label for="link_name"><?php echo NAME ?>:</label>
		<input type="text" name="link_name" id="link_name" class="form-control"<?php if ( count($menus) > 0 ) echo ' required' ?> maxlength="50" value="<?php echo $link_name ?>">
	</div>
</div>


<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>