<?php
include '../config.php';
$result = false;

// Check if all required values is defined from post and the values are not empty
if ( isset($_POST['type'], $_POST['section'], $_POST['data']) && !empty($_POST['type']) && !empty($_POST['section']) ) {
	// Do switch on the value from type
	switch ($_POST['type']) {
		// If the value is page-content, do this (defined in the tbody attribute data-type)
		case 'page-content':

			foreach($_POST['data'] as $order => $page_content)
			{
				$order	= intval($order) + 1;
				$id		= intval($page_content['id']);

				$query	=
					"UPDATE 
						page_content 
					SET 
						page_content_order = $order 
					WHERE 
						page_content_id = $id";
				$result = $mysqli->query($query);

				// If result returns false, run the function query_error do show debugging info
				if (!$result)
				{
					query_error($query, __LINE__, __FILE__);
				}
			}
			break;
	}
}
// Return the bool value from $result in assoc array, with the key status and use json_encode to output data as a json object
echo json_encode(['status' => $result]);