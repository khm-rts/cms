<?php
if ( !isset($view_files) )
{
	require '../config.php';
	$view_file = 'users';
}

// If session users is not defineds, define it with empty array
if ( !isset($_SESSION[$view_file]) )	$_SESSION[$view_file]				= [];
// If these URL params is set, save their value to session
if ( isset($_GET['page-no']) )		$_SESSION[$view_file]['page_no']		= $_GET['page-no'];
if ( isset($_GET['sort-by']) )		$_SESSION[$view_file]['sort_by']		= $_GET['sort-by'];
if ( isset($_GET['order']) )		$_SESSION[$view_file]['order']			= $_GET['order'];

if ( isset($_GET['page-length']) && $_GET['page-length'] >= min($page_lengths) && $_GET['page-length'] <= max($page_lengths) )
{
	$_SESSION[$view_file]['page_length']	= $_GET['page-length'];
	unset($_SESSION[$view_file]['page_no']);
}

// If search is defined in URL params and the value is not empty, save the value to session
if ( isset($_GET['search']) && !empty($_GET['search']) )
{
	$_SESSION[$view_file]['search'] = $_GET['search'];
	unset($_SESSION[$view_file]['page_no']);
}

// If search is defined in URL params and the value is empty, unset the session to clear search
if ( isset($_GET['search']) && empty($_GET['search']) ) unset($_SESSION[$view_file]['search']);

// Use value from session if defined, or use default values.
$page_length	= isset($_SESSION[$view_file]['page_length'])	? intval($_SESSION[$view_file]['page_length'])	: PAGE_LENGTH;
$page_no		= isset($_SESSION[$view_file]['page_no'])		? $_SESSION[$view_file]['page_no']				: 1;
$sort_by		= isset($_SESSION[$view_file]['sort_by'])		? $_SESSION[$view_file]['sort_by']				: 'created';
$order			= isset($_SESSION[$view_file]['order'])		? $mysqli->escape_string($_SESSION[$view_file]['order']) : 'desc';
$search			= isset($_SESSION[$view_file]['search'])		? $mysqli->escape_string($_SESSION[$view_file]['search']) : '';
$icon_created	= $icon_name = $icon_email = $icon_role = $icon_status = '';


if ($order == 'desc')
{
	$new_order	= 'asc';
	$icon		= $icons['sort-desc'];
}
else
{
	$new_order	= 'desc';
	$icon		= $icons['sort-asc'];
}

switch($sort_by)
{
	case 'created':
		$icon_created	= $icon;
		$order_by		= "user_created " . strtoupper($order);
		break;
	case 'name':
		$icon_name		= $icon;
		$order_by		= "user_name " . strtoupper($order);
		break;
	case 'email':
		$icon_email		= $icon;
		$order_by		= "user_email " . strtoupper($order);
		break;
	case 'role':
		$icon_role		= $icon;
		$order_by		= "role_name " . strtoupper($order);
		break;
	case 'status':
		$icon_status	= $icon;
		$order_by		= "user_status " . strtoupper($order);
		break;
}

// If delete and id is defined in URL params and the id is not empty, delete the selected user
if ( isset($_GET['delete'], $_GET['id']) && !empty($_GET['id']) )
{
	$id = intval($_GET['id']);

	// Get the selected users id from the URL param
	$id		= intval($_GET['id']);
	// Get the user from the Database
	$query	=
		"SELECT 
			user_name 
		FROM 
			users 
		WHERE 
			user_id = $id";
	$result = $mysqli->query($query);

	// If result returns false, use the function query_error to show debugging info
	if (!$result)
	{
		query_error($query, __LINE__, __FILE__);
	}

	// Delete the selected user if found
	if ( $result->num_rows == 1)
	{
		// Return the information from the Database as an object
		$row	= $result->fetch_object();

		$query =
			"DELETE FROM
				users 
			WHERE 
				user_id = $id";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result)
		{
			query_error($query, __LINE__, __FILE__);
		}

		create_event('delete', 'af brugeren ' . $row->user_name, 100);
	}
}
?>

<div class="page-title">
	<a class="<?php echo $buttons['create'] ?> pull-right" href="index.php?page=user-create" data-page="user-create"><?php echo $icons['create'] . CREATE_ITEM ?></a>
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
		<div class="row">
			<div class="col-md-4">
				<form class="form-inline" data-page="<?php echo $view_file ?>">
					<input type="hidden" name="page" value="<?php echo $view_file ?>">
					<label class="font-weight-300">
						Vis
						<select class="form-control input-sm" name="page-length" data-change="submit-form">
						<?php
						foreach($page_lengths as $key => $value)
						{
							$selected = $page_length == $key ? ' selected' : '';
							/*?>
							<option value="<?php echo $key ?>"<?php echo $selected ?>><?php echo $value ?></option>
							<?php*/
							echo '<option value="' . $key . '"' . $selected . '>' .$value .'</option>';

							//echo '<option value="' . $key . '"' . ($_SESSION['user']['page_length'] == $key ? ' selected' : ''). '>' .$value .'</option>';
						}
						?>
						</select>
						elementer
					</label>
				</form>
			</div>
			<div class="col-md-5 col-md-offset-3 text-right">
				<form data-page="<?php echo $view_file ?>">
					<input type="hidden" name="page" value="<?php echo $view_file ?>">
					<div class="input-group input-group-sm">
						<input type="search" name="search" id="search" class="form-control" placeholder="<?php echo PLACEHOLDER_SEARCH ?>" value="<?php echo $search ?>">
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
						<a href="index.php?page=<?php echo $view_file ?>&sort-by=created&order=<?php echo $new_order ?>" data-page="<?php echo $view_file ?>" data-params="sort-by=created&order=<?php echo $new_order ?>" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo $icon_created . CREATED ?></a>
					</th>
					<th>
						<a href="index.php?page=<?php echo $view_file ?>&sort-by=name&order=<?php echo $new_order ?>" data-page="<?php echo $view_file ?>" data-params="sort-by=name&order=<?php echo $new_order ?>" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo $icon_name . NAME ?></a>
					</th>
					<th>
						<a href="index.php?page=<?php echo $view_file ?>&sort-by=email&order=<?php echo $new_order ?>" data-page="<?php echo $view_file ?>" data-params="sort-by=email&order=<?php echo $new_order ?>" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo $icon_email . EMAIL ?></a>
					</th>
					<th>
						<a href="index.php?page=<?php echo $view_file ?>&sort-by=role&order=<?php echo $new_order ?>" data-page="<?php echo $view_file ?>" data-params="sort-by=role&order=<?php echo $new_order ?>" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo $icon_role . ROLE ?></a>
					</th>
					<th class="toggle">
						<a href="index.php?page=<?php echo $view_file ?>&sort-by=status&order=<?php echo $new_order ?>" data-page="<?php echo $view_file ?>" data-params="sort-by=status&order=<?php echo $new_order ?>" title="<?php echo SORT_BY_THIS_COLUMN ?>"><?php echo $icon_status . STATUS ?></a>
					</th>
					<th class="icon"></th>
					<th class="icon"></th>
				</tr>
				</thead>

				<tbody>
				<?php
				$search_sql = '';
				if ( !empty($search) )
				{
					$search_sql = " 
					WHERE 
						user_name LIKE '%$search%' 
					OR 
						user_email LIKE '%$search%'";
				}

				$query	=
					"SELECT 
						user_id, user_status, DATE_FORMAT(user_created, '" . DATETIME_FORMAT . "') AS user_created_formatted, user_name, user_email, role_name 
					FROM 
						users 
					INNER JOIN 
						roles ON users.fk_role_id = roles.role_id $search_sql";
				$result	= $mysqli->query($query);

				$items_total = $result->num_rows;

				$offset = ($page_no - 1) * $page_length;

				$query .=
					"
					ORDER BY 
						$order_by
					LIMIT 
						$page_length
					OFFSET 
						$offset";

				$result	= $mysqli->query($query);

				$items_current_total = $result->num_rows;

				prettyprint($query);

				if (!$result)
				{
					query_error($query, __LINE__, __FILE__);
				}

				while( $row = $result->fetch_object() )
				{
					?>
					<tr>
						<td><?php echo $row->user_created_formatted ?></td>
						<td><?php echo $row->user_name ?></td>
						<td><?php echo $row->user_email ?></td>
						<td><?php echo constant($row->role_name) ?></td>

						<!-- TOGGLE TIL AKTIVER/DEAKTIVER ELEMENT -->
						<td class="toggle">
							<input type="checkbox" class="toggle-checkbox" id="<?php echo $row->user_id ?>" data-type="users" <?php if ($row->user_status == 1) {  echo 'checked'; } ?>>
						</td>

						<!-- REDIGER LINK -->
						<td class="icon">
							<a class="<?php echo $buttons['edit'] ?>" href="index.php?page=user-edit&id=<?php echo $row->user_id ?>" data-page="user-edit" data-params="id=<?php echo $row->user_id ?>" title="<?php echo EDIT_ITEM ?>"><?php echo $icons['edit'] ?></a>
						</td>

						<!-- SLET LINK -->
						<td class="icon">
							<a class="<?php echo $buttons['delete'] ?>" data-toggle="confirmation" href="index.php?page=<?php echo $view_file ?>&id=<?php echo $row->user_id ?>&delete" data-page="<?php echo $view_file ?>" data-params="id=<?php echo $row->user_id ?>&delete" title="<?php echo DELETE_ITEM ?>"><?php echo $icons['delete'] ?></a>
						</td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
		</div><!-- /.table-responsive -->

		<div class="row">
			<div class="col-md-3">
				<?php
				echo sprintf(SHOWING_ITEMS_AMOUNT, ($items_current_total == 0 ) ? 0 : $offset + 1, $offset + $items_current_total, $items_total) ?>
			</div>
			<div class="col-md-9 text-right">
				<?php
				pagination($view_file, $page_no, $items_total, $page_length) ?>
			</div>
		</div>
	</div>
</div>

<?php
if (DEVELOPER_STATUS) { show_developer_info(); }
