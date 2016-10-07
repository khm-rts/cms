<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'page-content';
}

page_access($view_file);

// If page-id is not defined in URL params, or the value is empty, show alert
if ( !isset($_GET['page-id']) || empty($_GET['page-id']) )
{
	alert('danger', NO_ITEM_SELECTED);
}
// If page-id is defined, continue
else
{
	// Get the selected page id from the URL param
	$page_id = intval($_GET['page-id']);

	// If delete and id is defined in URL params  and the id is not empty, delete the selected page content
	if ( isset($_GET['delete'], $_GET['id']) && !empty($_GET['id']) )
	{
		// Get the selected page id from the URL param id
		$id		= intval($_GET['id']);
		// Get the page from the Database
		$query	=
			"SELECT 
				page_content_order, page_content_type, page_content_description, page_title, page_function_description
			FROM 
				page_content 
			INNER JOIN 
				pages ON page_content.fk_page_id = pages.page_id
			LEFT JOIN 
				page_functions ON page_content.fk_page_function_id = page_functions.page_function_id
			WHERE 
				page_content_id = $id";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		// Delete the selected page-content if found
		if ( $result->num_rows == 1)
		{
			// Return the information from the Database as an object
			$row	= $result->fetch_object();

			$query =
				"DELETE FROM
					page_content 
				WHERE 
					page_content_id = $id";
			$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			$current_order = $row->page_content_order;

			// Update order
			$query =
				"UPDATE 
					page_content 
				SET 
					page_content_order = page_content_order - 1 
				WHERE 
					page_content_order > $current_order 
				AND 
					fk_page_id = $page_id";
			$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			// Opret delete event i logbogen.
			create_event('delete', 'af indholdet ' . ($row->page_content_type == 1 ? $row->page_content_description : $row->page_function_description) . ' på ' . $row->page_title, $view_files[$view_file]['required_access_lvl']);
		}
	}

	// Get the page from the Database
	$query	=
		"SELECT 
			page_title
		FROM 
			pages 
		WHERE 
			page_id = $page_id";
	$result = $mysqli->query($query);

	// If result returns false, use the function query_error to show debugging info
	if (!$result) query_error($query, __LINE__, __FILE__);

	// Return the information from the Database as an object
	$row	= $result->fetch_object();

	?>
	<div class="page-title">
		<a class="<?php echo $buttons['create'] ?> pull-right" href="index.php?page=page-content-create&page-id=<?php echo $page_id ?>" data-page="page-content-create" data-params="page-id=<?php echo $page_id ?>"><?php echo $icons['create'] . CREATE_ITEM ?></a>
		<span class="title">
			<?php
			// Get icon and title from Array $files, defined in config.php
			echo $view_files[$view_file]['icon'] . ' ' . $row->page_title;
			?>
		</span>
	</div>

	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<div class="title"><?php echo OVERVIEW_TABLE_HEADER ?></div>
			</div>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th class="icon"><?php echo $icons['sort-asc'] ?></th>
						<th class="icon"></th>
						<th><?php echo TYPE ?></th>
						<th><?php echo DESCRIPTION ?></th>
						<th><?php echo LAYOUT ?></th>
						<th class="icon"></th>
						<th class="icon"></th>
					</tr>
					</thead>

					<tbody id="sortable" data-type="page-content" data-section="<?php echo $page_id ?>">
					<?php
					$query	=
						"SELECT 
							page_content_id, page_content_order, page_content_type, page_content_description, page_layout_description, page_function_description  
						FROM 
							page_content 
						INNER JOIN 
							page_layouts ON page_content.fk_page_layout_id = page_layouts.page_layout_id 
						LEFT JOIN 
							page_functions ON page_content.fk_page_function_id = page_functions.page_function_id 
						WHERE 
							fk_page_id = $page_id
						ORDER BY
							page_content_order";
					$result	= $mysqli->query($query);

					// If result returns false, run the function query_error do show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					prettyprint($query);

					while( $row = $result->fetch_object() )
					{
						?>
						<tr class="sortable-item" id="<?php echo $row->page_content_id ?>">
							<td class="icon"><?php echo $row->page_content_order ?></td>
							<td class="icon"><?php echo $icons['sort'] ?></td>
							<td>
								<?php
								// If content type is 1, show icon and text for 'Text editor' and if not show icon and text for 'Page function'
								echo $row->page_content_type == 1 ?  $view_files[$view_file]['icon'] . ' ' .EDITOR : $view_files['page-functions']['icon'] . ' ' .PAGE_FUNCTION;
								?>
							</td>
							<td>
								<?php
								// If content type is 1, show description from page_content table and if not, show description from page_layout table
								echo $row->page_content_type == 1 ? $row->page_content_description : $row->page_function_description;
								?>
							</td>
							<td><?php echo COLUMN ?>: <?php echo $row->page_layout_description ?></td>

							<!-- REDIGER LINK -->
							<td class="icon">
								<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=page-content-edit&page-id=<?php echo $page_id ?>&id=<?php echo $row->page_content_id ?>" data-page="page-content-edit" data-params="page-id=<?php echo $page_id ?>&id=<?php echo $row->page_content_id ?>" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
							</td>

							<!-- SLET LINK -->
							<td class="icon">
								<a class="<?php echo $buttons['delete'] ?>"  data-toggle="confirmation" href="index.php?page=<?php echo $view_file ?>&page-id=<?php echo $page_id ?>&id=<?php echo $row->page_content_id ?>&delete" data-page="<?php echo $view_file ?>" data-params="page-id=<?php echo $page_id ?>&id=<?php echo $row->page_content_id ?>&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
							</td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->
		</div>
	</div>
	<?php
}

if (DEVELOPER_STATUS) { show_developer_info(); }
