<?php
// If user is not logged in, redirect to new-profile / login
if ( !isset($_SESSION['user']['id']) )
{
	header('Location: index.php?page=ny-profil');
	exit;
}

// Get the users id from session and secure it's a number before using in sql
$user_id	= intval($_SESSION['user']['id']);

// Get the current users details from the database
$query	=
	"SELECT 
		user_email, user_name, user_address, user_zip, user_city, user_phone 
	FROM 
		users 
	WHERE 
		user_id = $user_id";
$result	= $mysqli->query($query);

// If result returns false, use the function query_error to show debugging info
if (!$result) query_error($query, __LINE__, __FILE__);

$row	= $result->fetch_object();

// Save values on variables used in form
$name			= $row->user_name;
$email			= $row->user_email;
$phone_tmp		= $row->user_phone;
$address_tmp	= $row->user_address;
$zip_tmp		= $row->user_zip;
$city_tmp		= $row->user_city;

// If form is posted
if ( isset($_POST['update_details']) )
{
	// Escape inputs and save values to variables defined before with empty value
	$name			= $mysqli->escape_string($_POST['name']);
	$email			= $mysqli->escape_string($_POST['email']);
	$phone_tmp		= $_POST['phone'];
	$address_tmp	= $_POST['address'];
	$zip_tmp		= $_POST['zip'];
	$city_tmp		= $_POST['city'];

	// If one of the required fields is empty, show alert
	if ( empty($_POST['name']) || empty($_POST['email']) )
	{
		alert('warning', 'Ikke alle påkrævede felter er udfyldt!');
	}
	// If all required fields is not empty, continue
	else
	{
		// Match users with this email, except the current user
		$query =
			"SELECT 
				user_id 
			FROM 
				users 
			WHERE 
				user_email = '$email'
			AND 
				user_id != $user_id";
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
			// If fields phone, address, zip or city is empty, save NULL value to the variables $phone, $address, $zip and $city. If fields is not empty escape the values from the form and add single quotes
			$phone		= empty($_POST['phone'])	? 'NULL' : "'" . $mysqli->escape_string($_POST['phone']) . "'";

			$address	= empty($_POST['address'])	? 'NULL' : "'" . $mysqli->escape_string($_POST['address']) . "'";

			$zip		= empty($_POST['zip'])		? 'NULL' : "'" . $mysqli->escape_string($_POST['zip']) . "'";

			$city		= empty($_POST['city'])		? 'NULL' : "'" . $mysqli->escape_string($_POST['city']) . "'";

			// Update the user in the database
			$query =
				"UPDATE 
					users 
				SET 
					user_name = '$name', user_email = '$email', user_phone = $phone, user_address = $address, user_zip = $zip, user_city = $city
				WHERE 
					user_id = $user_id";
			$result = $mysqli->query($query);

			// If result returns false, use the function query_error to show debugging info
			if (!$result) query_error($query, __LINE__, __FILE__);

			alert('success', 'Din profil blev opdateret');
		} // Closes else to: if ($result->num_rows > 0)
	} // Closes: ( empty($_POST['name']) || empty($_POST['email'])...
} // Closes: if ( isset($_POST['update_details']) )
?>
<form method="post">
	<div class="form-group">
		<label for="name">Fulde navn</label>
		<input type="text" class="form-control" name="name" id="name" required value="<?php echo $name ?>">
	</div>

	<div class="row">
		<div class="col-sm-12 col-md-6">
			<div class="form-group">
				<label for="address">Adresse <span class="text-muted">(valgfri)</span></label>
				<input type="text" class="form-control" name="address" id="address" value="<?php echo $address_tmp ?>">
			</div>
		</div>
		<div class="col-sm-4 col-md-2">
			<div class="form-group">
				<label for="zip">Post nr. <span class="text-muted">(valgfri)</span></label>
				<input type="number" class="form-control" name="zip" id="zip" value="<?php echo $zip_tmp ?>">
			</div>
		</div>
		<div class="col-sm-8 col-md-4">
			<div class="form-group">
				<label for="city">By <span class="text-muted">(valgfri)</span></label>
				<input type="text" class="form-control" name="city" id="city" value="<?php echo $city_tmp ?>">
			</div>
		</div>
	</div>
	<!-- /.row -->

	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label for="phone">Telefon <span class="text-muted">(valgfri)</span></label>
				<input type="number" class="form-control" name="phone" id="phone" value="<?php echo $phone_tmp ?>">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" name="email" id="email" required value="<?php echo $email ?>">
			</div>
		</div>
	</div>

	<div class="form-group">
		<button type="submit" name="update_details" class="btn btn-primary"><i class="fa fa-save"></i> Opdatér profil</button>
	</div>
</form>