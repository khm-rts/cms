<?php
if ( !isset($view_files) )
{
	require '../config.php';
	$view_file = 'index';
}
?>
<div class="row" style="padding-top: 14px">
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
		<a href="index.php?page=users" data-page="users">
			<div class="card red summary-inline">
				<div class="card-body">
					<?php echo str_replace('class="fa ', 'class="fa fa-4x ', $view_files['users']['icon']) // Add class fa-4x ?>
					<div class="content">
						<div class="title">
							<?php
							// Count amount of users
							$query =
								"SELECT
									COUNT(*) AS count
								FROM
									users";
							$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							$row = $result->fetch_object();

							echo $row->count
							?>
						</div>
						<div class="sub-title"><?php echo $view_files['users']['title'] ?></div>
					</div>
					<div class="clear-both"></div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
		<a href="index.php?page=pages" data-page="pages">
			<div class="card yellow summary-inline">
				<div class="card-body">
					<?php echo str_replace('class="fa ', 'class="fa fa-4x ', $view_files['pages']['icon']) // Add class fa-4x ?>
					<div class="content">
						<div class="title">
							<?php
							// Count amount of users
							$query =
								"SELECT
									COUNT(*) AS count
								FROM
									pages";
							$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							$row = $result->fetch_object();

							echo $row->count
							?>
						</div>
						<div class="sub-title"><?php echo $view_files['pages']['title'] ?></div>
					</div>
					<div class="clear-both"></div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
		<a href="index.php?page=posts" data-page="posts">
			<div class="card green summary-inline">
				<div class="card-body">
					<?php echo str_replace('class="fa ', 'class="fa fa-4x ', $view_files['posts']['icon']) // Add class fa-4x ?>
					<div class="content">
						<div class="title">
							<?php
							// Count amount of posts
							$query =
									"SELECT
									COUNT(*) AS count
								FROM
									posts";
							$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							$row = $result->fetch_object();

							echo $row->count
							?>
						</div>
						<div class="sub-title"><?php echo $view_files['posts']['title'] ?></div>
					</div>
					<div class="clear-both"></div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
		<a href="index.php?page=posts" data-page="posts">
			<div class="card blue summary-inline">
				<div class="card-body">
					<?php echo str_replace('class="fa ', 'class="fa fa-4x ', $view_files['comments']['icon']) // Add class fa-4x ?>
					<div class="content">
						<div class="title">
							<?php
							// Count amount of posts
							$query =
								"SELECT
									COUNT(*) AS count
								FROM
									comments";
							$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							$row = $result->fetch_object();

							echo $row->count
							?>
						</div>
						<div class="sub-title"><?php echo $view_files['comments']['title'] ?></div>
					</div>
					<div class="clear-both"></div>
				</div>
			</div>
		</a>
	</div>
</div>

<hr>

<?php
// If user logged in has access level equal or higher than the access level required for displaying comments, show last 5 comments
if ($_SESSION['user']['access_level'] >= $view_files['comments']['required_access_lvl'])
{
	?>
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<div class="title">
					<?php
					// Get icon and title from Array $files, defined in config.php
					echo $view_files['comments']['icon'] . ' ' . $view_files['comments']['title']
					?>
					<small>- <?php echo LATEST_AMOUNT_ELEMENTS ?></small>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th>
							<?php echo $icons['sort-desc'] . CREATED ?>
						</th>
						<th>
							<?php echo CONTENT ?>
						</th>
						<th>
							<?php echo USER ?>
						</th>
						<th>
							<?php echo BLOG_POSTS ?>
						</th>
					</tr>
					</thead>

					<tbody>
					<?php
					$query	=
							"SELECT 
								comment_id, DATE_FORMAT(comment_created, '" . DATETIME_FORMAT . "') AS comment_created_formatted, comment_content, user_name, post_id, post_title
							FROM 
								comments
							INNER JOIN
								users ON comments.fk_user_id = users.user_id
							INNER JOIN
								posts ON comments.fk_post_id = posts.post_id
							ORDER BY 
								comment_created DESC
							LIMIT 
								5";
					$result	= $mysqli->query($query);

					// If result returns false, use the function query_error to show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					while( $row = $result->fetch_object() )
					{
						?>
						<tr>
							<td><?php echo $row->comment_created_formatted ?></td>
							<td><?php echo $row->comment_content ?></td>

							<td><?php echo $row->user_name ?></td>

							<td><a href="index.php?page=comments&post-id=<?php echo $row->post_id ?>"><?php echo $row->post_title ?></a></td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->

			<a class="<?php echo $buttons['primary'] ?>" href="index.php?page=posts" data-page="posts"><?php echo SHOW_ALL . ' ' . $icons['next'] ?></a>
		</div>
	</div>
	<?php
}

echo '<hr>';

// If user logged in has access level equal or higher than the access level required for displaying users, show last 5 users
if ($_SESSION['user']['access_level'] >= $view_files['users']['required_access_lvl'])
{
	?>
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<div class="title">
					<?php
					// Get icon and title from Array $files, defined in config.php
					echo $view_files['users']['icon'] . ' ' . $view_files['users']['title']
					?>
					<small>- <?php echo LATEST_AMOUNT_ELEMENTS ?></small>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th>
							<?php echo $icons['sort-desc'] . CREATED ?>
						</th>
						<th>
							<?php echo NAME ?>
						</th>
						<th>
							<?php echo EMAIL ?>
						</th>
						<th>
							<?php echo ROLE ?>
						</th>
					</tr>
					</thead>

					<tbody>
					<?php
					$access_level_sql = '';
					// If current users access level is below 1000 (not Super Administrator), add filter to sql, so users with higher access level is not visible
					if ( $_SESSION['user']['access_level'] < 1000 )
					{
						$user_access_level	= intval($_SESSION['user']['access_level']);

						$access_level_sql = "
						WHERE role_access_level <= $user_access_level";
					}

					$query	=
						"SELECT 
							user_id, user_status, DATE_FORMAT(user_created, '" . DATETIME_FORMAT . "') AS user_created_formatted, user_name, user_email, role_name, role_access_level 
						FROM 
							users 
						INNER JOIN 
							roles ON users.fk_role_id = roles.role_id $access_level_sql
						ORDER BY 
							user_created DESC
						LIMIT 
							5";
					$result	= $mysqli->query($query);

					// If result returns false, use the function query_error to show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					while( $row = $result->fetch_object() )
					{
						?>
						<tr>
							<td><?php echo $row->user_created_formatted ?></td>
							<td><?php echo $row->user_name ?></td>
							<td><?php echo $row->user_email ?></td>
							<td><?php echo constant($row->role_name) ?></td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->

			<a class="<?php echo $buttons['primary'] ?>" href="index.php?page=users" data-page="users"><?php echo SHOW_ALL . ' ' . $icons['next'] ?></a>
		</div>
	</div>
	<?php
}

echo '<hr>';

// If user logged in has access level equal or higher than the access level required for displaying events, show last 5 events from log
if ($_SESSION['user']['access_level'] >= $view_files['events']['required_access_lvl'])
{
	?>
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<div class="title">
					<?php
					// Get icon and title from Array $files, defined in config.php
					echo $view_files['events']['icon'] . ' ' . $view_files['events']['title']
					?>
					<small>- <?php echo LATEST_AMOUNT_EVENTS ?></small>
				</div>
			</div>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th>
							<?php echo $icons['sort-desc'] . DATE_AND_TIME ?>
						</th>
						<th>
							<?php echo TYPE ?>
						</th>
						<th>
							<?php echo DESCRIPTION ?>
						</th>
						<th>
							<?php echo USER ?>
						</th>
						<th>
							<?php echo ROLE ?>
						</th>
					</tr>
					</thead>

					<tbody>
					<?php
					$access_level_sql = '';
					if ( $_SESSION['user']['access_level'] < 1000 )
					{
						$user_access_level	= intval($_SESSION['user']['access_level']);

						$access_level_sql	=
							"
							WHERE 
								event_access_level_required <= $user_access_level
							AND 
								role_access_level <= $user_access_level";
					}

					$query	=
							"SELECT 
								event_id, DATE_FORMAT(event_time, '" . DATETIME_FORMAT . "') AS event_time_formatted, event_description, event_type_name, event_type_class, user_name, role_name 
							FROM 
								events 
							INNER JOIN 
								event_types ON events.fk_event_type_id = event_types.event_type_id
							INNER JOIN 
								users ON events.fk_user_id = users.user_id 
							INNER JOIN 
								roles ON users.fk_role_id = roles.role_id $access_level_sql
							ORDER BY 
								event_time DESC
							LIMIT 
								5";

					$result	= $mysqli->query($query);

					// If result returns false, use the function query_error to show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					$items_total = $result->num_rows;

					while( $row = $result->fetch_object() )
					{
						?>
						<tr>
							<td><?php echo $row->event_time_formatted ?></td>
							<td><span class="label label-<?php echo $row->event_type_class ?>"><?php echo constant($row->event_type_name) ?></span></td>
							<td><?php echo $row->event_description ?></td>
							<td><?php echo $row->user_name ?></td>
							<td><?php echo constant($row->role_name) ?></td>
						</tr>
						<?php
					}
					?>
					</tbody>
				</table>
			</div><!-- /.table-responsive -->

			<a class="<?php echo $buttons['primary'] ?>" href="index.php?page=events" data-page="events"><?php echo SHOW_ALL . ' ' . $icons['next'] ?></a>
		</div><!-- /.card-body -->
	</div><!-- /.card -->
	<?php
}

show_developer_info();
