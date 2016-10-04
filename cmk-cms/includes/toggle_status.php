<?php
include '../config.php';
$result = false;

// Check if all required values is defined from post and the values are not empty
if ( isset($_POST['type'], $_POST['status'], $_POST['id']) && !empty($_POST['type']) && !empty($_POST['id']) )
{
	// Do switch on the value from type
	switch ($_POST['type'])
	{
		// If the value is users, do this (defined in the toggles attribute data-type)
		case 'users':
			// Don't delete the current user
			if ($_POST['id'] != $_SESSION['user']['id'])
			{
				// Secure the value from id is int
				$id		= intval($_POST['id']);

				// Get the user from the Database
				$query	=
					"SELECT 
						role_access_level 
					FROM 
						users 
					INNER JOIN 
						roles ON users.fk_role_id = roles.role_id
					WHERE 
						user_id = $id";
				$result_user = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result_user)
				{
					query_error($query, __LINE__, __FILE__);
				}

				// Delete the selected user if found
				if ( $result_user->num_rows == 1)
				{
					// Return the information from the Database as an object
					$row = $result_user->fetch_object();

					// Only toggle the selected user if the access level is below the current users access level or is super admin
					if ($row->role_access_level < $_SESSION['user']['access_level'] || $_SESSION['user']['access_level'] == 1000)
					{
						// If status is true, save 1 to $status, or save 0
						$status	= $_POST['status'] ? 1 : 0;

						// Update status for toggled user
						$query =
							"UPDATE 
								users 
							SET 
								user_status = $status 
							WHERE 
								user_id = $id";
						$result = $mysqli->query($query);

						// If result returns false, run the function query_error do show debugging info
						if (!$result)
						{
							query_error($query, __LINE__, __FILE__);
						}
					}
				} // Close: if ( $result->num_rows == 1)
			} // Close: if ($_POST['id'] != $_SESSION['user']['id'])
			break;
	}
}
// Return the bool value from $result in assoc array, with the key status and use json_encode to output data as a json object
echo json_encode(['status' => $result]);