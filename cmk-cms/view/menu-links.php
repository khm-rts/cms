<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file 		= 'menu-links';
}

page_access($view_file);

// If menu-id is not defined in URL params, or the value is empty, show alert
if ( !isset($_GET['menu-id']) || empty($_GET['menu-id']) )
{
	alert('danger', NO_ITEM_SELECTED);
}
// If page-id is defined, continue
else {
	// Get the selected page id from the URL param
	$menu_id = intval($_GET['menu-id']);

	// If delete and id is defined in URL params  and the id is not empty, delete the selected menu link
	if (isset($_GET['delete'], $_GET['id']) && !empty($_GET['id'])) {
		// Get the selected page id from the URL param id
		$id = intval($_GET['id']);

		delete_menu_link($id, $menu_id);
	}

	// Get the menu from the Database
	$query =
		"SELECT 
			menu_name
		FROM 
			menus 
		WHERE 
			menu_id = $menu_id";
	$result = $mysqli->query($query);

	// If result returns false, use the function query_error to show debugging info
	if (!$result) query_error($query, __LINE__, __FILE__);

	// Return the information from the Database as an object
	$row = $result->fetch_object();
	?>

	<div class="page-title">
		<a class="<?php echo $buttons['create'] ?> pull-right" href="index.php?page=menu-link-create&menu-id=<?php echo $menu_id ?>" data-page="menu-link-create" data-params="menu-id=<?php echo $menu_id ?>"><?php echo $icons['create'] . CREATE_ITEM ?></a>
		<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files[$view_file]['icon'] . ' ' . $row->menu_name;
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
						<th><?php echo NAME ?></th>
						<th><?php echo LINKS ?></th>
						<th class="icon"></th>
						<th class="icon"></th>
					</tr>
					</thead>

					<tbody id="sortable" data-type="menu-links" data-section="<?php echo $menu_id ?>">
					<?php
					// Get all links from the database
					$query =
						"SELECT 
						 	menu_link_id, menu_link_order, menu_link_name, menu_link_bookmark, menu_link_type_name, menu_link_type_prefix_url, page_url_key, post_url_key 
						FROM 
							menu_links 
						INNER JOIN
							menus_menu_links ON menu_links.menu_link_id = menus_menu_links.fk_menu_link_id
						INNER JOIN
							menu_link_types ON menu_links.fk_link_type_id = menu_link_types.menu_link_type_id
						INNER JOIN 
							pages ON menu_links.fk_page_id = pages.page_id 
						LEFT JOIN 
							posts ON menu_links.fk_post_id = posts.post_id
						WHERE 
							menus_menu_links.fk_menu_id = $menu_id 
						ORDER BY 
							menu_link_order";

					$result	= $mysqli->query($query);

					// If result returns false, run the function query_error do show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					// prettyprint($query);

					while( $row = $result->fetch_object() )
					{
						$link = $row->page_url_key . $row->menu_link_type_prefix_url . $row->post_url_key . $row->menu_link_bookmark;
						?>
						<tr class="sortable-item" id="<?php echo $row->menu_link_id ?>">
							<td class="icon"><?php echo $row->menu_link_order ?></td>
							<td class="icon"><?php echo $icons['sort'] ?></td>
							<td><?php echo constant($row->menu_link_type_name) ?></td>
							<td><?php echo $row->menu_link_name ?></td>
							<td><a href="../<?php echo $link ?>" target="_blank">/<?php echo $link ?></a></td>

							<!-- REDIGER LINK -->
							<td class="icon">
								<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=menu-link-edit&menu-id=<?php echo $menu_id ?>&id=<?php echo $row->menu_link_id ?>" data-page="menu-link-edit" data-params="menu-id=<?php echo $menu_id ?>&id=<?php echo $row->menu_link_id ?>" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
							</td>

							<!-- SLET LINK -->
							<td class="icon">
								<a class="<?php echo $buttons['delete'] ?>"  data-toggle="confirmation" href="index.php?page=menu-links&menu-id=<?php echo $menu_id ?>&id=<?php echo $row->menu_link_id ?>&delete" data-page="menu-links" data-params="menu-id=<?php echo $menu_id ?>&id=<?php echo $row->menu_link_id ?>&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
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
?>



<?php
show_developer_info();
