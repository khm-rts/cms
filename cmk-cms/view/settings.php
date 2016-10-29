<?php
// If view_files is not defined, the page is not included in ../index.php, so it's missing config.php and updated $view_file with current_page
if ( !isset($view_files) )
{
	require '../config.php';
	$view_file = 'settings';
}

page_access($view_file);

// Get settings from the database
$query =
	"SELECT
		setting_person_name, setting_company_name, setting_email, setting_phone, setting_street, setting_zip, setting_city
	FROM
		settings
	WHERE
		setting_id = 1";
$result = $mysqli->query($query);

// If result returns false, use the function query_error to show debugging info
if (!$result) query_error($query, __LINE__, __FILE__);

// Save settings information from the database into the variable $row
$row = $result->fetch_object();

$name			= $row->setting_person_name;
$company_tmp	= $row->setting_company_name;
$email			= $row->setting_email;
$phone_tmp		= $row->setting_phone;
$street_tmp		= $row->setting_street;
$zip_tmp		= $row->setting_zip;
$city_tmp		= $row->setting_city;
?>

<div class="page-title">
	<span class="title">
		<?php
		// Get icon and title from Array $files, defined in config.php
		echo $view_files['settings']['icon'] . ' ' . $view_files['settings']['title']
		?>
	</span>
</div>

<div class="card">
	<div class="card-body">
		<form method="post" data-page="settings">
			<?php
			// If the form has been submitted
			if ( isset($_POST['save_item']) )
			{
				// Escape inputs and save values to variables defined before with empty value
				$name			= $mysqli->escape_string($_POST['name']);
				$company_tmp	= $_POST['company'];
				$email			= $mysqli->escape_string($_POST['email']);
				$phone_tmp		= $_POST['phone'];
				$street_tmp		= $_POST['street'];
				$zip_tmp		= $_POST['zip'];
				$city_tmp		= $_POST['city'];

				// If one of the required fields is empty, show alert
				if ( empty($_POST['name']) || empty($_POST['email']) )
				{
					alert('warning', REQUIRED_FIELDS_EMPTY);
				}
				// If all required fields is not empty, continue
				else
				{
					// If company, street or city is empty, save NULL value to the variable $company, $street and $city. If not empty escape the value from the form and add single quotes
					$company= empty($_POST['company'])	? 'NULL' : "'" . $mysqli->escape_string($_POST['company']) . "'";

					$street	= empty($_POST['street'])	? 'NULL' : "'" . $mysqli->escape_string($_POST['street']) . "'";

					$city	= empty($_POST['city'])		? 'NULL' : "'" . $mysqli->escape_string($_POST['city']) . "'";

					// If phone or zip is empty, save NULL value to the variable $phone and $zip. If not empty, secure the value from the form is a number
					$phone	= empty($_POST['phone'])	? 'NULL' : intval($_POST['phone']);

					$zip	= empty($_POST['zip'])		? 'NULL' : intval($_POST['zip']);

					// Update the settings in the database
					$query	=
							"UPDATE
								settings
							SET
								setting_person_name = '$name', setting_company_name = $company, setting_email = '$email', setting_phone = $phone, setting_street = $street, setting_zip = $zip, setting_city = $city";
					$result = $mysqli->query($query);

					// If result returns false, use the function query_error to show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					// Use function to insert event in log
					create_event('update', 'af indstillinger', $view_files[$view_file]['required_access_lvl']);

					alert('success', ITEM_UPDATED);
				} // Close else to: if ( empty($_POST['name'])...
			} // Close: if ( isset($_POST['save_item']) )
			?>
			<div class="form-group">
				<label for="name"><?php echo NAME ?>:</label>
				<input type="text" name="name" id="name" class="form-control" required maxlength="100" autofocus value="<?php echo $name ?>">
			</div>

			<div class="form-group">
				<label for="company"><?php echo COMPANY ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
				<input type="text" name="company" id="company" class="form-control" maxlength="100" autofocus value="<?php echo $company_tmp ?>">
			</div>

			<div class="form-group">
				<label for="email"><?php echo EMAIL ?>:</label>
				<input type="email" name="email" id="email" class="form-control" required maxlength="100" value="<?php echo $email ?>">
			</div>

			<div class="form-group">
				<label for="phone"><?php echo PHONE ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
				<input type="number" name="phone" id="phone" class="form-control" value="<?php echo $phone_tmp ?>">
			</div>

			<div class="form-group">
				<label for="street"><?php echo ADDRESS ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
				<input type="text" name="street" id="street" class="form-control" maxlength="255" value="<?php echo $street_tmp ?>">
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-3">
						<label for="zip"><?php echo ZIP ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
						<input type="number" name="zip" id="zip" class="form-control" value="<?php echo $zip_tmp ?>">
					</div>
					<div class="col-md-9">
						<label for="city"><?php echo CITY ?>: <small class="text-muted">(<?php echo OPTIONAL ?>)</small></label>
						<input type="text" name="city" id="city" class="form-control" maxlength="100" value="<?php echo $city_tmp ?>">
					</div>
				</div>
			</div>

			<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
				<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
			</button>
		</form>
	</div>
</div>

<?php
show_developer_info();
