<?php
// If user is already logged in, redirect to profile
if ( isset($_SESSION['user']['id']) )
{
	header('Location: index.php?page=profil');
	exit;
}

// Save variables with empty values, to be used in the forms input values
$name = $email  = '';

// If the form has been submitted
if ( isset($_POST['create_user']) )
{
	// Escape inputs and save values to variables defined before with empty value
	$name	= $mysqli->escape_string($_POST['name']);
	$email	= $mysqli->escape_string($_POST['email']);

	// If one of the required fields is empty, show alert
	if ( empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password']) )
	{
		alert('warning', 'Ikke alle påkrævede felter er udfyldt!');
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
			alert('warning', 'Den indtastede e-mailadresse er ikke tilgængelig');
		}
		// If email is available, continue
		else
		{
			// If the typed password isn't the same, show alert
			if ($_POST['password'] != $_POST['confirm_password'])
			{
				alert('warning', 'De indtastede adgangskoder er ikke ens');
			}
			// If the password matched, continue
			else
			{
				// Use password_hash with the algorithm from the predefined constant PASSWORD_DEFAULT, and default cost
				$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

				// Insert the user to the database
				$query =
					"INSERT INTO 
						users (user_name, user_email, user_password) 
					VALUES 
						('$name', '$email', '$password_hash')";
				$result = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);

				// Log brugeren automatisk ind
				if ( login($email, $_POST['password']) )
				{
					header('Location: index.php?page=profil');
					exit;
				}
			}
		} // Closes else to: if ($result->num_rows > 0)
	} // Closes: ( empty($_POST['name']) || empty($_POST['email'])...
} // Closes: if ( isset($_POST['create_user']) )
?>


<form method="post">
	<div class="form-group">
		<label for="name">Fulde navn</label>
		<input type="text" class="form-control" name="name" id="name" required value="<?php echo $name ?>">
	</div>

	<div class="form-group">
		<label for="email">Email</label>
		<input type="email" class="form-control" name="email" id="email" required value="<?php echo $email ?>">
	</div>

	<div class="form-group">
		<label for="password">Adgangskode</label>
		<input type="password" class="form-control" name="password" id="password" required>
	</div>

	<div class="form-group">
		<label for="confirm_password">Bekræft adgangskode</label>
		<input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
	</div>

	<div class="form-group">
		<button type="submit" name="create_user" class="btn btn-primary"><i class="fa fa-user-plus"></i> Opret profil</button>
	</div>
</form>