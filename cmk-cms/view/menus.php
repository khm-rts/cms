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
				$query	=
					"SELECT 
						*
					FROM 
						menus 
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

						<!-- LINK TIL SIDEINDHOLD -->
						<td class="icon">
							<a href="index.php?page=menu-links&menu-id=<?php echo $row->menu_id ?>" title="<?php echo $view_files['menu-links']['title'] ?>" data-page="menu-links" data-params="menu-id=<?php echo $row->menu_id ?>"><?php echo $view_files['menu-links']['icon'] ?></a>
						</td>

						<!-- TOGGLE TIL AKTIVER/DEAKTIVER ELEMENT -->
						<td class="toggle">
							<input type="checkbox" class="toggle-checkbox" id="<?php echo $row->menu_id ?>" data-type="menu-status" <?php if ($row->menu_status == 1) {  echo 'checked'; } ?>>
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
if (DEVELOPER_STATUS) { show_developer_info(); }
