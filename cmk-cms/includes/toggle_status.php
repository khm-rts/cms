<?php
include '../config.php';
$result = false;

// Check if all required values is defined from post and the values are not empty
if ( isset($_POST['type'], $_POST['status'], $_POST['id']) && !empty($_POST['type']) && !empty($_POST['id']) ) {
	// Do switch on the value from type
	switch ($_POST['type']) {
		// If the value is users, do this (defined in the toggles attribute data-type)
		case 'users':
			// Don't delete the current user
			if ($_POST['id'] != $_SESSION['user']['id']) {
				// Secure the value from id is int
				$id = intval($_POST['id']);

				// Get the user from the Database
				$query =
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
				if (!$result_user) query_error($query, __LINE__, __FILE__);

				// Delete the selected user if found
				if ($result_user->num_rows == 1) {
					// Return the information from the Database as an object
					$row = $result_user->fetch_object();

					// Only toggle the selected user if the access level is below the current users access level or is super admin
					if ( $row->role_access_level < $_SESSION['user']['access_level'] || is_super_admin() ) {
						// If status is true, save 1 to $status, or save 0
						$status = $_POST['status'] == 'true' ? 1 : 0;

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
						if (!$result) query_error($query, __LINE__, __FILE__);
					}
				} // Close: if ( $result->num_rows == 1)
			} // Close: if ($_POST['id'] != $_SESSION['user']['id'])
			break;

		// If the value is page-protected, do this (defined in the toggles attribute data-type)
		case 'page-protected':

			if ( is_super_admin() )
			{
				// Secure the value from id is int
				$id = intval($_POST['id']);

				// If status is true, save 1 to $status, or save 0
				$status = $_POST['status'] == 'true' ? 1 : 0;

				// Update status for toggled user
				$query =
					"UPDATE 
						pages 
					SET 
						page_protected = $status 
					WHERE 
						page_id = $id";
					$result = $mysqli->query($query);

				// If result returns false, run the function query_error do show debugging info
				if (!$result) query_error($query, __LINE__, __FILE__);
			}
			break;

		// If the value is page-status, do this (defined in the toggles attribute data-type)
		case 'page-status':
			// If the current users access level is equal og greater than the required access level for pages, update status
			if ($_SESSION['user']['access_level'] >= $view_files['pages']['required_access_lvl'])
			{
				// Secure the value from id is int
				$id = intval($_POST['id']);

				// Get the user from the Database
				$query =
					"SELECT 
						page_protected 
					FROM 
						pages 
					WHERE 
						page_id = $id";
				$result_page = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result_page) query_error($query, __LINE__, __FILE__);

				// Return the information from the Database as an object
				$row = $result_page->fetch_object();

				// Only toggle page_status if page is not protected or the current user is Super Admin
				if ($row->page_protected != 1 || is_super_admin() )
				{
					// If status is true, save 1 to $status, or save 0
					$status = $_POST['status'] == 'true' ? 1 : 0;

					// Update status for toggled user
					$query =
						"UPDATE 
							pages 
						SET 
							page_status = $status 
						WHERE 
							page_id = $id";
					$result = $mysqli->query($query);

					// If result returns false, run the function query_error do show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);
				}
			}
			break;

		// If the value is page-status, do this (defined in the toggles attribute data-type)
		case 'posts':
			// If the current users access level is equal og greater than the required access level for posts, update status
			if ($_SESSION['user']['access_level'] >= $view_files['posts']['required_access_lvl'])
			{
				// Secure the value from id is int
				$id = intval($_POST['id']);

				// Get the post from the Database with info for the user who created the post
				$query	=
					"SELECT 
						post_title, user_id, role_access_level
					FROM 
						posts 
					INNER JOIN
						users ON posts.fk_user_id = users.user_id
					INNER JOIN
						roles ON users.fk_role_id = roles.role_id
					WHERE 
						post_id = $id";
				$result_page = $mysqli->query($query);

				// If result returns false, use the function query_error to show debugging info
				if (!$result_page) query_error($query, __LINE__, __FILE__);

				// Return the information from the Database as an object
				$row = $result_page->fetch_object();

				// Only toggle status on the current post if it's the users own post or the creators access level is below the current users or current user is super admin
				if ($row->user_id == $_SESSION['user']['id'] || $row->role_access_level < $_SESSION['user']['access_level'] || is_super_admin() )
				{
					// If status is true, save 1 to $status, or save 0
					$status = $_POST['status'] == 'true' ? 1 : 0;

					// Update status for toggled user
					$query =
						"UPDATE 
							posts 
						SET 
							post_status = $status 
						WHERE 
							post_id = $id";
					$result = $mysqli->query($query);

					// If result returns false, run the function query_error do show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);
				}
			}
			break;
	}
}
// Return the bool value from $result in assoc array, with the key status and use json_encode to output data as a json object
echo json_encode(['status' => $result]);