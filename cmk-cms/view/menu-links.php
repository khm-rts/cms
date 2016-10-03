<?php
if ( !isset($view_files) )
{
	require '../config.php';
}
?>

<div class="page-title">
	<a class="<?php echo $buttons['create'] ?> pull-right" href="index.php?page=menu-link-create&menu-id=1" data-page="menu-link-create" data-params="menu-id=1"><?php echo $icons['create'] . CREATE_ITEM ?></a>
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['menu-links']['icon'] . ' Main';
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

				<tbody id="sortable" data-type="menu-links" data-section="1">
				<tr class="sortable-item" id="1">
					<td class="icon">1</td>
					<td class="icon"><?php echo $icons['sort'] ?></td>
					<td><?php echo PAGE ?></td>
					<td>Forside</td>
					<td><a href="../" target="_blank">/</a></td>

					<!-- REDIGER LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=menu-link-edit&menu-id=1&id=1" data-page="menu-link-edit" data-params="menu-id=1&id=1" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
					</td>

					<!-- SLET LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['delete'] ?>"  data-toggle="confirmation" href="index.php?page=menu-links&menu-id=1&id=1&delete" data-page="menu-links" data-params="menu-id=1&id=1&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
					</td>
				</tr>

				<tr class="sortable-item" id="2">
					<td class="icon">2</td>
					<td class="icon"><?php echo $icons['sort'] ?></td>
					<td><?php echo PAGE ?></td>
					<td>Blog</td>
					<td><a href="../blog" target="_blank">/blog</a></td>

					<!-- REDIGER LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=menu-link-edit&menu-id=1&id=2" data-page="menu-link-edit" data-params="menu-id=1&id=2" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
					</td>

					<!-- SLET LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['delete'] ?>" data-toggle="confirmation" href="index.php?page=menu-links&menu-id=1&id=2&delete" data-page="menu-links" data-params="menu-id=1&id=2&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
					</td>
				</tr>

				<tr class="sortable-item" id="3">
					<td class="icon">3</td>
					<td class="icon"><?php echo $icons['sort'] ?></td>
					<td><?php echo BLOG_POSTS ?></td>
					<td>Indlæg 1</td>
					<td><a href="../blog/post/eksempel-paa-indlaeg-1" target="_blank">/blog/post/eksempel-paa-indlaeg-1</a></td>

					<!-- REDIGER LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=menu-link-edit&menu-id=1&id=3" data-page="menu-link-edit" data-params="menu-id=1&id=3" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
					</td>

					<!-- SLET LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['delete'] ?>" data-toggle="confirmation" href="index.php?page=menu-links&menu-id=1&id=3&delete" data-page="menu-links" data-params="menu-id=1&id=3&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
					</td>
				</tr>

				<tr class="sortable-item" id="4">
					<td class="icon">2</td>
					<td class="icon"><?php echo $icons['sort'] ?></td>
					<td><?php echo PAGE ?></td>
					<td>Kontakt</td>
					<td><a href="../kontakt" target="_blank">/kontakt</a></td>

					<!-- REDIGER LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=menu-link-edit&menu-id=1&id=4" data-page="menu-link-edit" data-params="menu-id=1&id=4" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
					</td>

					<!-- SLET LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['delete'] ?>" data-toggle="confirmation" href="index.php?page=menu-links&menu-id=1&id=4&delete" data-page="menu-links" data-params="menu-id=1&id=4&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
					</td>
				</tr>
				</tbody>
			</table>
		</div><!-- /.table-responsive -->
	</div>
</div>

<?php
if (DEVELOPER_STATUS) { show_developer_info(); }
