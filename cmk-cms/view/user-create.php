<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$root			= '../';
	$include_path	= $root . $include_path;
	$view_file		= 'user-create';
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
			<div class="title"><?php echo CREATE_ITEM ?></div>
		</div>
	</div>

	<div class="card-body">
		<form method="post" data-page="<?php echo $view_file ?>">
			<?php
			// Save variables with empty values, to be used in the forms input values
			$name = $email = $role_id = $password_required_label = $phone_tmp = $address_tmp = $zip_tmp = $city_tmp = '';
			$password_required = 'required';

			// If the form has been submitted
			if ( isset($_POST['save_item']) )
			{
				// Escape inputs and save values to variables defined before with empty value
				$name			= $mysqli->escape_string($_POST['name']);
				$email			= $mysqli->escape_string($_POST['email']);
				$phone_tmp		= $_POST['phone'];
				$address_tmp	= $_POST['address'];
				$zip_tmp		= $_POST['zip'];
				$city_tmp		= $_POST['city'];

				// If one of the required fields is empty, show alert
				if ( empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password']) || empty($_POST['role']) )
				{
					alert('warning', REQUIRED_FIELDS_EMPTY);
				}
				// If all required fields is not empty, continue
				else
				{
					// Match users with this email
					$query =
						"SELECT 
							user_id 
						FROM 
							users 
						WHERE 
							user_email = '$email'";
					$result = $mysqli->query($query);

					// If result returns false, use the function query_error to show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					// If any rows was found, the email is not available, so show alert
					if ($result->num_rows > 0)
					{
						alert('warning', EMAIL_NOT_AVAILABLE);
					}
					// If email is available, continue
					else
					{
						// If the typed password isn't the same, show alert
						if ($_POST['password'] != $_POST['confirm_password'])
						{
							alert('warning', PASSWORD_MISMATCH);
						}
						// If the password matched, continue
						else
						{
							// Get the id for the selected role
							$role_id	= intval($_POST['role']);
							// Get the selected role's access level from the database
							$query	=
								"SELECT 
									role_access_level 
								FROM 
									roles 
								WHERE 
									role_id = $role_id";
							$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							$role	= $result->fetch_object();

							// If selected role's access level higher or equal to the current users access level and the current user is not super admin, owerwrite the selected role_id with the default value (role_id for 'User')
							if ($role->role_access_level >= $_SESSION['user']['access_level'] && $_SESSION['user']['access_level'] != 1000) $role_id = 4;

							// Use password_hash with the algorithm from the predefined constant PASSWORD_DEFAULT, and default cost
							$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

							// If fields phone, address, zip or city is empty, save NULL value to the variables $phone, $address, $zip and $city. If fields is not empty escape the values from the form and add single quotes
							$phone		= empty($_POST['phone'])	? 'NULL' : "'" . $mysqli->escape_string($_POST['phone']) . "'";

							$address	= empty($_POST['address'])	? 'NULL' : "'" . $mysqli->escape_string($_POST['address']) . "'";

							$zip		= empty($_POST['zip'])		? 'NULL' : "'" . $mysqli->escape_string($_POST['zip']) . "'";

							$city		= empty($_POST['city'])		? 'NULL' : "'" . $mysqli->escape_string($_POST['city']) . "'";

							// Insert the user to the database
							$query =
								"INSERT INTO 
									users (user_name, user_email, user_password, user_phone, user_address, user_zip, user_city, fk_role_id) 
								VALUES 
									('$name', '$email', '$password_hash', $phone, $address, $zip, $city, $role_id)";
							$result = $mysqli->query($query);

							// If result returns false, use the function query_error to show debugging info
							if (!$result) query_error($query, __LINE__, __FILE__);

							// Get the newly created user id
							$user_id = $mysqli->insert_id;

							// Use function to insert event in log
							create_event('create', 'af brugeren <a href="index.php?page=user-edit&id=' . $user_id . '" data-page="user-edit" data-params="id='. $user_id . '">' . $name . '</a>', 100);

							alert('success', ITEM_CREATED . ' <a href="index.php?page=users" data-page="users">' . RETURN_TO_OVERVIEW . '</a>');
						}
					} // Closes else to: if ($result->num_rows > 0)
				} // Closes: ( empty($_POST['name']) || empty($_POST['email'])...
			} // Closes: if ( isset($_POST['save_item']) )

			include $include_path . 'form-user.php'
			?>
		</form>
	</div>
</div>

<?php
show_developer_info();
