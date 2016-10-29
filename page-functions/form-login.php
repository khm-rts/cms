<?php
// If the login form has been submitted
if ( isset($_POST['login']) )
{
	// Use function to sign in and if it returns true, redirect user to profile
	if ( login($_POST['email'], $_POST['password']) )
	{
		header('Location: index.php?page=ret-profil');
		exit;
	}
}
?>

<form method="post">
	<div class="form-group">
		<label for="email">Email</label>
		<input type="text" class="form-control" name="email" id="email" required>
	</div>
	<div class="form-group">
		<label for="password">Adgangskode</label>
		<input type="password" class="form-control" name="password" id="password" required>
	</div>
	<div class="form-group">
		<button type="submit" name="login" class="btn btn-primary"><i class="fa fa-sign-in"></i> Log ind</button>
	</div>
</form>