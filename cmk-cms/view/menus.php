<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file 		= 'menus';
}

page_access($view_file);
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
			<div class="title"><?php echo OVERVIEW_TABLE_HEADER ?></div>
		</div>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover table-striped">
				<thead>
				<tr>
					<th>
						<?php echo NAME ?>
					</th>
					<th>
						<?php echo DESCRIPTION ?>
					</th>
					<th class="icon"></th>
				</tr>
				</thead>

				<tbody>
				<?php
				// Get all menus from database and join links to count how many there is
				$query	=
					"SELECT 
						menu_id, menu_name, menu_description, COUNT(fk_menu_link_id) AS links
					FROM 
						menus 
					LEFT JOIN
						menus_menu_links ON menus.menu_id = menus_menu_links.fk_menu_id
					GROUP BY
						menu_id
					ORDER BY 
						menu_name";
				$result	= $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);

				while( $row = $result->fetch_object() )
				{
					?>
					<tr>
						<td><?php echo $row->menu_name ?></td>
						<td><?php echo $row->menu_description ?></td>

						<!-- LINK TIL MENULINKS -->
						<td class="icon">
							<a href="index.php?page=menu-links&menu-id=<?php echo $row->menu_id ?>" title="<?php echo $view_files['menu-links']['title'] ?>" data-page="menu-links" data-params="menu-id=<?php echo $row->menu_id ?>"><?php echo $view_files['menu-links']['icon'] ?></a>
						</td>

						<td class="icon"><?php echo $row->links ?></td>
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
show_developer_info();
