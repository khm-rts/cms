<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_login" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Log på</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                    	<input type="email" name="login_email" placeholder="E-mailadresse" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                    	<input type="password" name="login_password" placeholder="Adgangskode" class="form-control" required=>
                    </div>
					<?php
					// If the login form has been submitted
					if ( isset($_POST['login_email']) )
					{
						// Use function to sign in and save bool in the variable $login_status
						$login_status = login($_POST['login_email'], $_POST['login_password']);
						// If $login_status contains true, update the current page
						if ($login_status)
						{
							header('Location: ' . $_SERVER['REQUEST_URI']);
							exit;
						}
					}
					?>
					<button class="btn btn-success btn-block" type="submit"><i class="fa fa-sign-in"></i> Log på</button>
                </div>
                <div class="modal-footer">
					<a href="index.php?page=ny-profil" class="btn btn-default">Opret ny profil</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Luk</button>
                </div>
            </form>
        </div>
    </div>
</div>