<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'menu-link-create';
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
				<div class="title"><?php echo CREATE_ITEM ?></div>
			</div>
		</div>

		<div class="card-body">
			<form method="post" data-page="menu-link-create" data-params="menu-id=<?php echo $menu_id ?>">
				<?php
				// Save variables with empty values, to be used in the forms input values
				$name = $page = $post_tmp = $bookmark_tmp = '';
				$menus = [$menu_id];
				$link_type = 1;

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

					create_menu_link($menus, $name, $page, $link_type, $bookmark_tmp, $post_tmp);

				} // Closes: if ( isset($_POST['save_item']) )

				include $include_path . 'form-menu-link.php'
				?>
			</form>
		</div>
	</div>
	<?php
}

show_developer_info();
