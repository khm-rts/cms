<div class="form-group">
	<label for="title"><?php echo TITLE ?>:</label>
	<input type="text" name="title" id="title" class="form-control" required maxlength="55" autofocus value="<?php echo $title ?>">
</div>

<div class="form-group">
	<label for="url_key"><?php echo URL_KEY ?>:</label>
	<input type="text" name="url_key" id="url_key" class="form-control" required maxlength="55" pattern="([a-z0-9-.])+" title="<?php echo INVALID_URL_KEY ?>" value="<?php echo $url_key ?>">
</div>

<div class="form-group">
	<label for="content"><?php echo CONTENT ?>:</label>
	<textarea name="content" id="content"><?php echo $content_tmp ?></textarea>
	<script>
		CKEDITOR.replace('content', {
			toolbar: 'Full'
		})
	</script>
</div>

<div class="form-group">
	<label for="meta_description"><?php echo META_DESCRIPTION ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
	<textarea name="meta_description" id="meta_description" class="form-control" maxlength="155"><?php echo $meta_description_tmp ?></textarea>
</div>

<div class="form-group">
	<label for="category"><?php echo CATEGORY ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
	<select class="select2" name="category" id="category">
		<option value="" hidden><?php echo SELECT_AN_OPTION ?></option>
		<?php
		// Get the categories from the database
		$query =
				"SELECT
					category_id, category_name
				FROM 
					categories 
				ORDER BY 
					category_name";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		while( $row = $result->fetch_object() )
		{
			// If current value in $category_id_tmp matches the row from the database, add selected to the variable $selected
			$selected = $category_id_tmp == $row->category_id ? ' selected' : '';

			echo '<option value="' . $row->category_id . '"' . $selected . '>' . $row->category_name . '</option>';
		}
		?>
	</select>
</div>

<div class="form-group">
	<label for="tags"><?php echo TAG ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
	<select class="select2" multiple name="tags[]" id="tags" data-placeholder="<?php echo SELECT_AN_OPTION ?>">
		<?php
		// Get the tags from the database
		$query =
				"SELECT
					tag_id, tag_name
				FROM 
					tags 
				ORDER BY 
					tag_name";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		while( $row = $result->fetch_object() )
		{
			// If row from the database matches a tag id in the array $tags, add selected to the variable $selected
			$selected = in_array($row->tag_id, $tags) ? ' selected' : '';

			echo '<option value="' . $row->tag_id . '"' . $selected . '>' . $row->tag_name . '</option>';
		}
		?>
	</select>
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
		<label for="page"><?php echo PAGE ?>:</label>
		<select class="form-control" name="page" id="page"<?php if ( count($menus) > 0 ) echo ' required' ?>>
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
				$selected = $page_id == $row->page_id ? ' selected' : '';

				echo '<option value="' . $row->page_id . '"' . $selected . '>' . $row->page_title . '</option>';
			}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="link_name"><?php echo NAME ?>:</label>
		<input type="text" name="link_name" id="link_name" class="form-control"<?php if ( count($menus) > 0 ) echo ' required' ?> maxlength="50" value="<?php echo $link_name ?>">
	</div>
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>