<?php
// If user is not logged in, redirect to new-profile / login
if ( !isset($_SESSION['user']['id']) )
{
	header('Location: index.php?page=ny-profil');
	exit;
}

// Get the users id from session and secure it's a number before using in sql
$user_id	= intval($_SESSION['user']['id']);

// If form is posted
if ( isset($_POST['update_password']) )
{
	// If one of the required fields is empty, show alert
	if ( empty($_POST['password']) || empty($_POST['new_password']) || empty($_POST['confirm_new_password']) )
	{
		alert('warning', 'Ikke alle påkrævede felter er udfyldt!');
	}
	// If all required fields is not empty, continue
	else
	{
		// If the typed password isn't the same, show alert
		if ($_POST['new_password'] != $_POST['confirm_new_password'])
		{
			alert('warning', 'De indtastede adgangskoder er ikke ens');
		}
		// If the password matched, continue
		else
		{
			// Get the users password hash from the database
			$query	=
				"SELECT 
					user_password
				FROM 
					users 
				WHERE 
					user_id = $user_id
				AND 
					user_status = 1";
			$result	= $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			// Return data from the database and save in the variable $row
			$row = $result->fetch_object();

			// Check if the typed password matches the password hash in the database
			if ( password_verify($_POST['password'], $row->user_password) )
			{
				// Use password_hash with the algorithm from the predefined constant PASSWORD_DEFAULT, and default cost
				$password_hash	= password_hash($_POST['new_password'], PASSWORD_DEFAULT);

				// Update the password in he database
				$query =
					"UPDATE 
						users 
					SET 
						user_password = '$password_hash'
					WHERE 
						user_id = $user_id";
				$result	= $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);

				alert('success', 'Din adgangskode blev opdateret');
			}
			// If the typed password didn't match the password hash in the database
			else
			{
				alert('warning', 'Den indtastede adgangskode er ikke korrekt');
			}
		} // Close else to: if ($_POST['new_password'] != $_POST['confirm_new_password'])
	} // Close: if ( empty($_POST['password']) || empty($_POST['new_password'])...
} // Close: if ( isset($_POST['update_password']) )
?>

<form method="post">
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="password">Nuværende adgangskode</label>
				<input type="password" class="form-control" name="password" id="password" required>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="new_password">Ny adgangskode</label>
				<input type="password" class="form-control" name="new_password" id="new_password" required>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="confirm_new_password">Bekræft ny adgangskode</label>
				<input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" required>
			</div>
		</div>
	</div>
	<!-- /.row -->

	<div class="form-group">
		<button type="submit" name="update_password" class="btn btn-primary"><i class="fa fa-save"></i> Opdatér adgangskode</button>
	</div>
</form>