<div class="side-menu sidebar-inverse">
	<nav class="navbar navbar-default" role="navigation">
		<div class="side-menu-container">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">
					<div class="icon fa fa-paper-plane"></div>
					<div class="title">CMK Admin</div>
				</a>
				<button type="button" class="navbar-expand-toggle pull-right visible-xs">
					<i class="fa fa-times icon"></i>
				</button>
			</div>
			<ul class="nav navbar-nav">
				<?php
				// Loop through the Array $view_files, defined in config.php and save the Array keys as $file and the Array values as $details
				foreach($view_files as $file => $details)
				{
					// If nav in file details is set to true, show file in navigation
					if ($details['nav'] == true)
					{
						// Define the active variable with empty value
						$active = '';

						// If the file being included in index.php matches the current key from this Array, add the class active to the variable
						if ( $view_file == $file )
						{
							$active = ' class="active"';
						}
						?>
						<li<?php echo $active ?>>
							<?php
							// If $file is not equal to index, add parameter view with the current file as value
							?>
							<a href="<?php echo $file == 'index' ? './' : 'index.php?page=' . $file; ?>" data-page="<?php echo $file ?>">
								<?php echo $details['icon'] ?><span class="title"><?php echo $details['title'] ?></span>
							</a>
						</li>
						<?php
					}

				}
				?>
				<li>
					<a href="../" target="_blank"><?php echo $icons['external-link'] . '<span class="title">' . GO_TO_SITE . '</span>'?></a>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</nav>
</div>