<div class="form-group">
	<label for="name"><?php echo NAME ?>:</label>
	<input type="text" name="name" id="name" class="form-control" required minlength="3" maxlength="100" autofocus value="<?php echo $name ?>">
</div>

<div class="form-group">
	<label for="email"><?php echo EMAIL ?>:</label>
	<input type="email" name="email" id="email" class="form-control" required maxlength="100" value="<?php echo $email ?>">
</div>

<div class="form-group">
	<label for="password"><?php echo PASSWORD ?>: <?php echo $password_required_label ?></label>
	<input type="password" name="password" id="password" class="form-control" <?php echo $password_required ?> minlength="4" value="">
</div>

<div class="form-group">
	<label for="confirm_password"><?php echo CONFIRM_PASSWORD ?>: <?php echo $password_required_label ?></label>
	<input type="password" name="confirm_password" id="confirm_password" class="form-control" <?php echo $password_required ?> minlength="4" value="">
</div>

<div class="form-group">
	<label for="role"><?php echo ROLE ?>:</label>
	<select class="form-control" name="role" id="role" <?php if (isset($id) && $id == $_SESSION['user']['id']) { echo 'disabled'; } else { echo 'required'; } // If our own user, set disabled and if not set required on ?>>
		<?php
		$access_level_sql = '';
		// If it's our own user, only show our access level
		if (isset($id) && $id == $_SESSION['user']['id'])
		{
			$user_access_level	= intval($_SESSION['user']['access_level']);

			$access_level_sql = "
				WHERE role_access_level = $user_access_level";
		}
		// If current users access level is below 1000 (not Super Administrator), add filter to sql, so roles with higher or equal access level is not visible
		else if ( $_SESSION['user']['access_level'] < 1000 )
		{
			$user_access_level	= intval($_SESSION['user']['access_level']);

			$access_level_sql = "
				WHERE role_access_level < $user_access_level";
		}

		$query =
			"SELECT 
				role_id, role_name 
			FROM 
				roles $access_level_sql 
			ORDER BY 
				role_access_level DESC";
		$result = $mysqli->query($query);

		// If result returns false, use the function query_error to show debugging info
		if (!$result) query_error($query, __LINE__, __FILE__);

		// Do while-loop to create option for each row in the database
		while( $row = $result->fetch_object() )
		{
			// If the value saved in $role matches the current rows role_id, add the attribute selected
			// The role name in the database is a constant, so we use constant() on the value to display the real name from lang/da_DK.php
			echo '<option value="' . $row->role_id . '"' . ($role_id == $row->role_id ? ' selected' : '') . '>' . constant($row->role_name) . '</option>';
		}
		?>
	</select>
</div>

<button type="submit" class="<?php echo $buttons['save'] ?>" name="save_item">
	<?php echo $icons['save'] . ' ' .SAVE_CHANGES ?>
</button>