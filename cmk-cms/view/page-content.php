<?php
if ( !isset($view_files) )
{
	require '../config.php';
}
?>

<div class="page-title">
	<a class="<?php echo $buttons['create'] ?> pull-right" href="index.php?page=page-content-create&page-id=1" data-page="page-content-create" data-params="page-id=1"><?php echo $icons['create'] . CREATE_ITEM ?></a>
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['page-content']['icon'] . ' Blog';
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

				<tbody id="sortable" data-type="page-content" data-section="2">
				<tr class="sortable-item" id="1">
					<td class="icon">1</td>
					<td class="icon"><?php echo $icons['sort'] ?></td>
					<td><?php echo $view_files['page-content']['icon'] . ' ' .EDITOR ?></td>
					<td>Overskrift og kort beskrivelse</td>
					<td><?php echo COLUMN ?>: 100%</td>

					<!-- REDIGER LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=page-content-edit&page-id=1&id=1" data-page="page-content-edit" data-params="page-id=1&id=1" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
					</td>

					<!-- SLET LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['delete'] ?>"  data-toggle="confirmation" href="index.php?page=page-content&page-id=1&id=1&delete" data-page="page-content" data-params="page-id=1&id=1&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
					</td>
				</tr>

				<tr class="sortable-item" id="2">
					<td class="icon">2</td>
					<td class="icon"><?php echo $icons['sort'] ?></td>
					<td><?php echo $view_files['page-functions']['icon'] . ' ' .PAGE_FUNCTION ?></td>
					<td>Blog: Oversigt over indlæg</td>
					<td><?php echo COLUMN ?>: 100%</td>

					<!-- REDIGER LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=page-content-edit&page-id=1&id=2" data-page="page-content-edit" data-params="page-id=1&id=2" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
					</td>

					<!-- SLET LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['delete'] ?>" data-toggle="confirmation" href="index.php?page=page-content&page-id=1&id=2&delete" data-page="page-content" data-params="page-id=1&id=2&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
					</td>
				</tr>
				</tbody>
			</table>
		</div><!-- /.table-responsive -->
	</div>
</div>

<?php
if (DEVELOPER_STATUS) { show_developer_info(); }
