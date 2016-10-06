<div class="form-group">
	<label for="content_type"><?php echo TYPE ?>:</label>
	<select class="form-control" name="content_type" id="content_type">
		<option value="1"<?php if ($content_type == 1) { echo ' selected'; } ?>><?php echo EDITOR ?></option>
		<option value="2"<?php if ($content_type == 2) { echo ' selected'; } ?>><?php echo PAGE_FUNCTION ?></option>
	</select>
</div>

<div id="1"<?php if ($content_type == 2) { echo ' style="display: none"'; } ?>>
	<div class="form-group">
		<label for="description"><?php echo DESCRIPTION ?>:</label>
		<input type="text" name="description" id="description" class="form-control" required maxlength="255" value="<?php echo $description_tmp ?>">
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

<div class="form-group" id="2"<?php if ($content_type == 1) { echo ' style="display: none"'; } ?>>
	<label for="page_function"><?php echo PAGE_FUNCTION ?>:</label>
	<select class="form-control" name="page_function" id="page_function">
		<option value="1">Blog: Oversigt over indlæg</option>
		<option value="2">Kontaktformular</option>
	</select>
</div>

<div class="form-group">
	<label for="layout"><?php echo LAYOUT ?>:</label>
	<select class="form-control" name="layout" id="layout">
		<?php
		// Get the layout from the database
		$query =
			"SELECT
				page_layout_id, page_layout_description 
			FROM 
				page_layouts 
			ORDER BY 
				page_layout_description";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		while( $row = $result->fetch_object() )
		{
			// If current value in $layout matches the row from the database, add selected to the variable $selected
			$selected = $layout == $row->page_layout_id ? ' selected' : '';

			echo '<option value="' . $row->page_layout_id . '"' . $selected . '>' . COLUMN . ': ' . $row->page_layout_description . '</option>';
		}
		?>
	</select>
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>