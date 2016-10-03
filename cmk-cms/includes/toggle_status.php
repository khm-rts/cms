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
			// Secure the value from id is int
			$id		= intval($_POST['id']);
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
			break;
	}
}
// Return the bool value from $result in assoc array, with the key status and use json_encode to output data as a json object
echo json_encode(['status' => $result]);