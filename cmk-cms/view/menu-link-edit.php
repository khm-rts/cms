<?php
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'menu-link-edit';
}

page_access($view_file);

// If menu-id is not defined in URL params, or the value is empty, show alert
if ( !isset($_GET['menu-id']) || empty($_GET['menu-id']) )
{
	alert('danger', NO_ITEM_SELECTED);
}
// If menu-id is defined, continue
else
{
	// Get the selected menu id from the URL param
	$menu_id = intval($_GET['menu-id']);

	?>
	<div class="page-title">
		<span class="title">
			<?php
			// Get icon and title from Array $files, defined in config.php
			echo $view_files[$view_file]['icon'] . ' ' . $view_files[$view_file]['title']
			?>
		</span>
	</div>

	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<div class="title"><?php echo EDIT_ITEM ?></div>
			</div>
		</div>

		<div class="card-body">
			<form method="post" data-page="menu-link-edit" data-params="menu-id=<?php echo $menu_id ?>&id=<?php echo $_GET['id'] ?>">
				<?php
				if ( !isset($_GET['id']) || empty($_GET['id']) )
				{
					alert('danger', NO_ITEM_SELECTED);
				}
				else
				{
					// Get the selected menu link id from the URL param
					$id = intval($_GET['id']);

					// Get the menu link from the Database
					$query =
						"SELECT 
							menu_link_name, menu_link_bookmark, fk_link_type_id, fk_page_id, fk_post_id, GROUP_CONCAT(menu_id) AS menus
						FROM 
							menu_links 
						INNER JOIN
							menus_menu_links ON menu_links.menu_link_id = menus_menu_links.fk_menu_link_id
						INNER JOIN
							menus ON menus_menu_links.fk_menu_id = menus.menu_id
						WHERE 
							menu_link_id = $id";
					$result = $mysqli->query($query);

					// If result returns false, use the function query_error to show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					// Return the information from the Database as an object
					$row = $result->fetch_object();

					// Save variables with values from the database, to be used in the forms input values
					$menus				= explode(',', $row->menus); // Convert CSV to array with explode
					$bookmark_tmp 		= $row->menu_link_bookmark;
					$name				= $row->menu_link_name;
					$link_type			= $row->fk_link_type_id;
					$page				= $row->fk_page_id;
					$post_tmp			= $row->fk_post_id;

					// If the form has been submitted
					if ( isset($_POST['save_item']) )
					{
						// Escape inputs and save values to variables defined before with empty value
						$menus				= isset($_POST['menus']) ? $_POST['menus'] : [];
						$name				= $mysqli->escape_string($_POST['name']);
						$bookmark_tmp 		= $_POST['bookmark'];
						$link_type			= intval($_POST['link_type']);
						$page				= intval($_POST['page']);
						$post_tmp			= $_POST['post'];

						update_menu_link($menus, $id, $name, $page, $link_type, $bookmark_tmp, $post_tmp);

					} // Closes: if ( isset($_POST['save_item']) )

					include $include_path . 'form-menu-link.php';
				}
				?>
			</form>
		</div>
	</div>
	<?php
}

show_developer_info();
