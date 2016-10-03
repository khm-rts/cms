<?php
if ( !isset($view_files) )
{
	require '../config.php';
}
?>

<div class="page-title">
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['menus']['icon'] . ' ' . $view_files['menus']['title']
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
				<tr>
					<td>Main</td>
					<td>Hovedmenu på hjemmesiden</td>

					<!-- LINK TIL SIDEINDHOLD -->
					<td class="icon">
						<a href="index.php?page=menu-links&menu-id=1" title="<?php echo $view_files['menu-links']['title'] ?>" data-page="menu-links" data-params="menu-id=1"><?php echo $view_files['menu-links']['icon'] ?></a>
					</td>
				</tr>

				<tr>
					<td>Footer</td>
					<td>Menu i bunden af hjemmesiden</td>

					<!-- LINK TIL SIDEINDHOLD -->
					<td class="icon">
						<a href="index.php?page=menu-links&menu-id=2" title="<?php echo $view_files['menu-links']['title'] ?>" data-page="menu-links" data-params="menu-id=2"><?php echo $view_files['menu-links']['icon'] ?></a>
					</td>
				</tr>
				</tbody>
			</table>
		</div><!-- /.table-responsive -->
	</div>
</div>

<?php
if (DEVELOPER_STATUS) { show_developer_info(); }
