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
		echo $view_files['events']['icon'] . ' ' . $view_files['events']['title']
		?>
	</span>
</div>

<div class="card">
	<div class="card-header">
		<div class="card-title">
			<div class="title"><?php echo LOGBOOK_DESCRIPTION ?></div>
		</div>
	</div>

	<div class="card-body">
		<div class="row">
			<div class="col-md-4">
				<form class="form-inline" data-page="events">
					<input type="hidden" name="page" value="events">
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
				<form data-page="events">
					<input type="hidden" name="page" value="events">
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
						<a href="index.php?page=events&sort-by=timestamp&order=asc" data-page="events" data-params="sort-by=timestamp&order=asc" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo $icons['sort-desc'] . DATE_AND_TIME ?></a>
					</th>
					<th>
						<a href="index.php?page=events&sort-by=type&order=asc" data-page="events" data-params="sort-by=type&order=asc" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo TYPE ?></a>
					</th>
					<th>
						<a href="index.php?page=events&sort-by=description&order=asc" data-page="events" data-params="sort-by=description&order=asc" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo DESCRIPTION ?></a>
					</th>
					<th>
						<a href="index.php?page=events&sort-by=user-name&order=asc" data-page="events" data-params="sort-by=user-name&order=asc" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo USER ?></a>
					</th>
					<th>
						<a href="index.php?page=events&sort-by=role-name&order=asc" data-page="events" data-params="sort-by=role-name&order=asc" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo ROLE ?></a>
					</th>
				</tr>
				</thead>

				<tbody>
				<tr>
					<td>ons, 22. jul 2015 kl. 22:36</td>
					<td><span class="label label-success"><?php echo CREATION ?></span></td>
					<td>af brugeren <a href="#">"Finn Juhl"</a></td>
					<td>Kasper Madsen</td>
					<td>Super Administrator</td>
				</tr>

				<tr>
					<td>lør, 11. jul 2015 kl. 17:56</td>
					<td><span class="label label-danger"><?php echo DELETION ?></span></td>
					<td>af siden "Kontakt"</td>
					<td>Arne Jacobsen</td>
					<td>Administrator</td>
				</tr>

				<tr>
					<td>man, 8. jun 2015 kl. 09:12</td>
					<td><span class="label label-warning"><?php echo UPDATE ?></span></td>
					<td>af blog-indlægget <a href="#">"Lorem ipsum..."</a></td>
					<td>Børge Mogensen</td>
					<td>Moderator</td>
				</tr>

				<tr>
					<td>fre, 5. jun 2015 kl. 10:25</td>
					<td><span class="label label-info"><?php echo INFORMATION ?></span></td>
					<td>Loggede ind</td>
					<td>Hans Wegner</td>
					<td>Bruger</td>
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
					<li><a href="index.php?page=events&page-no=2" data-page="events" data-params="page-no=2">2</a></li>
					<li><a href="index.php?page=events&page-no=3" data-page="events" data-params="page-no=3">3</a></li>
					<li><a href="index.php?page=events&page-no=4" data-page="events" data-params="page-no=4">4</a></li>
					<li><a href="index.php?page=events&page-no=5" data-page="events" data-params="page-no=5">5</a></li>
					<li class="disabled">
						<span>&hellip;</span>
					</li>
					<li><a href="index.php?page=events&page-no=9" data-page="events" data-params="page-no=9">9</a></li>
					<li><a href="index.php?page=events&page-no=2" data-page="events" data-params="page-no=2"><?php echo $icons['next'] ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php
if (DEVELOPER_STATUS) { show_developer_info(); }
