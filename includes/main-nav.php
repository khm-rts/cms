<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="./">Start Bootstrap</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="main-nav">
			<ul class="nav navbar-nav">
				<?php
				// Use function to get links for main-nav which has menu id: 1
				get_menu_links(1, $page_url_key, $post_url_key);
				?>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<?php
				// If a user is logged in, display his name link to edit profile and link to sign out
				if ( isset($_SESSION['user']['id']) )
				{
					// Get the selected users id from the session
					$current_user_id = intval($_SESSION['user']['id']);

					// Get the user from the Database
					$query	=
							"SELECT 
								user_name 
							FROM 
								users 
							WHERE 
								user_id = $current_user_id";
					$result = $mysqli->query($query);

					// If result returns false, use the function query_error to show debugging info
					if (!$result) query_error($query, __LINE__, __FILE__);

					// Return the information from the Database as an object
					$user	= $result->fetch_object();
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user->user_name ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php if ($_SESSION['user']['access_level'] >= 10) { ?>
							<li>
								<a href="cmk-cms/index.php" target="_blank"><i class="fa fa-fw fa-external-link"></i> Gå til Administration</a>
							</li>
							<li class="divider"></li>
							<?php } ?>
							<li>
								<a href="index.php?page=profil"><i class="fa fa-fw fa-edit"></i> Rediger profil</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="index.php?logout"><i class="fa fa-fw fa-power-off"></i> Log af</a>
							</li>
						</ul>
					</li>
					<?php
				}
				// If no user is signed in, display link to modal where he can sign in
				else
				{
					?>
					<li><a href="#" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-in"></i> Log på</a></li>
					<?php
				}
				?>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container -->
</nav>