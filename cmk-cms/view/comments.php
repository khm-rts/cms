<?php
if ( !isset($view_files) )
{
	require '../config.php';
}
?>

<div class="page-title">
	<a class="<?php echo $buttons['create'] ?> pull-right" href="index.php?page=comment-create&post-id=1" data-page="comment-create" data-params="post-id=1"><?php echo $icons['create'] . CREATE_ITEM ?></a>
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['comments']['icon'] . ' Eksempel på indlæg 1'
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
		<div class="row">
			<div class="col-md-4">
				<form class="form-inline" data-page="comments">
					<input type="hidden" name="page" value="comments">
					<input type="hidden" name="post-id" value="1">
					<label class="font-weight-300">
						Vis
						<select class="form-control input-sm" name="page-length" data-change="submit-form">
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
						elementer
					</label>
				</form>
			</div>
			<div class="col-md-5 col-md-offset-3 text-right">
				<form data-page="comments">
					<input type="hidden" name="page" value="comments">
					<input type="hidden" name="post-id" value="1">
					<div class="input-group input-group-sm">
						<input type="search" name="search" id="search" class="form-control" placeholder="<?php echo PLACEHOLDER_SEARCH ?>" value="">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><?php echo $icons['search'] ?></button>
						</span>
					</div>
				</form>
			</div>
		</div>

		<div class="table-responsive">
			<table class="table table-hover table-striped">
				<thead>
				<tr>
					<th>
						<a href="index.php?page=comments&sort-by=created&order=asc" data-page="comments" data-params="sort-by=created&order=asc" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo $icons['sort-desc'] . CREATED ?></a>
					</th>
					<th>
						<a href="index.php?page=comments&sort-by=content&order=asc" data-page="comments" data-params="sort-by=content&order=asc" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo CONTENT ?></a>
					</th>
					<th>
						<a href="index.php?page=comments&sort-by=user-name&order=asc" data-page="comments" data-params="sort-by=user-name&order=asc" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo USER ?></a>
					</th>
					<th class="icon"></th>
					<th class="icon"></th>
				</tr>
				</thead>

				<tbody>
				<tr>
					<td>ons, 22. jul 2015 kl. 22:36</td>
					<td>Eksempel 2 på svar til indlæg 1</td>

					<td>Arne Jacobsen</td>

					<!-- REDIGER LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=comment-edit&post-id=1&id=1" data-page="comment-edit" data-params="post-id=1&id=1" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
					</td>

					<!-- SLET LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['delete'] ?>" data-toggle="confirmation" href="index.php?page=comments&post-id=1&id=1&delete" data-page="comments" data-params="post-id=1&id=1&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
					</td>
				</tr>

				<tr>
					<td>lør, 11. jul 2015 kl. 17:56</td>
					<td>Eksempel 2 på svar til indlæg 1</td>

					<td>Hans Wegner</td>

					<!-- REDIGER LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=comment-edit&post-id=1&id=2" data-page="comment-edit" data-params="post-id=1&id=2"  title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
					</td>

					<!-- SLET LINK -->
					<td class="icon">
						<a class="<?php echo $buttons['delete'] ?>" data-toggle="confirmation" href="index.php?page=comments&post-id=1&id=2&delete" data-page="comments" data-params="post-id=1&id=2&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
					</td>
				</tr>
				</tbody>
			</table>
		</div><!-- /.table-responsive -->

		<div class="row">
			<div class="col-md-3">
				<?php echo sprintf(SHOWING_ITEMS_AMOUNT, 1, 10, 97) ?>
			</div>
			<div class="col-md-9 text-right">
				<ul class="pagination">
					<li class="disabled"><a href=""><?php echo $icons['previous'] ?></a></li>
					<li class="active"><span>1</span></li>
					<li><a href="index.php?page=comments&page-no=2&post-id=1" data-page="comments" data-params="page-no=2&post-id=1">2</a></li>
					<li><a href="index.php?page=comments&page-no=3&post-id=1" data-page="comments" data-params="page-no=3&post-id=1">3</a></li>
					<li><a href="index.php?page=comments&page-no=4&post-id=1" data-page="comments" data-params="page-no=4&post-id=1">4</a></li>
					<li><a href="index.php?page=comments&page-no=5&post-id=1" data-page="comments" data-params="page-no=5&post-id=1">5</a></li>
					<li class="disabled">
						<span>&hellip;</span>
					</li>
					<li><a href="index.php?page=comments&page-no=9&post-id=1" data-page="comments" data-params="page-no=9&post-id=1">9</a></li>
					<li><a href="index.php?page=comments&page-no=2&post-id=1" data-page="comments" data-params="page-no=2&post-id=1"><?php echo $icons['next'] ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php
if (DEVELOPER_STATUS) { show_developer_info(); }
