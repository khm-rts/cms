<?php
if ( !isset($view_files) )
{
	require '../config.php';

	// If view is set in URL params, save value to variable $view_file or use index
	$view_file = isset($_GET['page']) ? $_GET['page'] : 'index';
}


if ( $view_file == 'index' )
{
	// Get icon and title from Array $files, defined in config.php
	echo '<li class="active">' . $view_files['index']['icon'] . $view_files['index']['title'] . '</li>';
}
else
{
	// Get icon and title from Array $files, defined in config.php
	echo '<li><a href="./" data-page="index">' . $view_files['index']['icon'] . $view_files['index']['title'] . '</a></li>';

	switch ($view_file)
	{
		case 'error':
			echo '<li class="active">' . $view_files['error']['icon'] . (isset($_GET['status']) ? 'HTTP ' . $_GET['status'] : ERROR) . '</li>';
			break;

		case 'settings':
			echo '<li class="active">' . $view_files['settings']['icon'] . $view_files['settings']['title'] . '</li>';
			break;

		case 'users':
			echo '<li class="active">' . $view_files['users']['icon'] . $view_files['users']['title'] . '</li>';
			break;

			case 'user-create':
				echo '<li><a href="index.php?page=users" data-page="users">' . $view_files['users']['icon'] . $view_files['users']['title'] . '</a></li>';
				echo '<li class="active">' . $icons['create'] . CREATE_ITEM . '</li>';
				break;

			case 'user-edit':
				echo '<li><a href="index.php?page=users" data-page="users">' . $view_files['users']['icon'] . $view_files['users']['title'] . '</a></li>';
				echo '<li class="active">' . $icons['edit'] . EDIT_ITEM . '</li>';
				break;

		case 'pages':
			echo '<li class="active">' . $view_files['pages']['icon'] . $view_files['pages']['title'] . '</li>';
			break;

			case 'page-create':
				echo '<li><a href="index.php?page=pages" data-page="pages">' . $view_files['pages']['icon'] . $view_files['pages']['title'] . '</a></li>';
				echo '<li class="active">' . $icons['create'] . CREATE_ITEM . '</li>';
				break;

			case 'page-edit':
				echo '<li><a href="index.php?page=pages" data-page="pages">' . $view_files['pages']['icon'] . $view_files['pages']['title'] . '</a></li>';
				echo '<li class="active">' . $icons['edit'] . EDIT_ITEM . '</li>';
				break;

			case 'page-content':
				echo '<li><a href="index.php?page=pages" data-page="pages">' . $view_files['pages']['icon'] . $view_files['pages']['title'] . '</a></li>';
				echo '<li class="active">' . $view_files['page-content']['icon'] . $view_files['page-content']['title'] . '</li>';
				break;

				case 'page-content-create':
					echo '<li><a href="index.php?page=pages" data-page="pages">' . $view_files['pages']['icon'] . $view_files['pages']['title'] . '</a></li>';
					echo '<li><a href="index.php?page=page-content&page-id=1" data-page="page-content" data-params="page-id=1">' . $view_files['page-content']['icon'] . $view_files['page-content']['title'] . '</a></li>';
					echo '<li class="active">' . $icons['create'] . CREATE_ITEM . '</li>';
					break;

				case 'page-content-edit':
					echo '<li><a href="index.php?page=pages" data-page="pages">' . $view_files['pages']['icon'] . $view_files['pages']['title'] . '</a></li>';
					echo '<li><a href="index.php?page=page-content&page-id=1" data-page="page-content" data-params="page-id=1">' . $view_files['page-content']['icon'] . $view_files['page-content']['title'] . '</a></li>';
					echo '<li class="active">' . $icons['edit'] . EDIT_ITEM . '</li>';
					break;

		case 'menus':
			echo '<li class="active">' . $view_files['menus']['icon'] . $view_files['menus']['title'] . '</li>';
			break;

			case 'menu-links':
				echo '<li><a href="index.php?page=menus" data-page="menus">' . $view_files['menus']['icon'] . $view_files['menus']['title'] . '</a></li>';
				echo '<li class="active">' . $view_files['menu-links']['icon'] . $view_files['menu-links']['title'] . '</li>';
				break;

				case 'menu-link-create':
					echo '<li><a href="index.php?page=menus" data-page="menus">' . $view_files['menus']['icon'] . $view_files['menus']['title'] . '</a></li>';
					echo '<li><a href="index.php?page=menu-links&menu-id=1" data-page="menu-links" data-params="menu-id=1">' . $view_files['menu-links']['icon'] . $view_files['menu-links']['title'] . '</a></li>';
					echo '<li class="active">' . $icons['create'] . CREATE_ITEM . '</li>';
					break;

				case 'menu-link-edit':
					echo '<li><a href="index.php?page=menus" data-page="menus">' . $view_files['menus']['icon'] . $view_files['menus']['title'] . '</a></li>';
					echo '<li><a href="index.php?page=menu-links&menu-id=1" data-page="menu-links" data-params="menu-id=1">' . $view_files['menu-links']['icon'] . $view_files['menu-links']['title'] . '</a></li>';
					echo '<li class="active">' . $icons['edit'] . EDIT_ITEM . '</li>';
					break;

		case 'posts':
			echo '<li class="active">' . $view_files['posts']['icon'] . $view_files['posts']['title'] . '</li>';
			break;

			case 'post-create':
				echo '<li><a href="index.php?page=posts" data-page="posts">' . $view_files['posts']['icon'] . $view_files['posts']['title'] . '</a></li>';
				echo '<li class="active">' . $icons['create'] . CREATE_ITEM . '</li>';
				break;

			case 'post-edit':
				echo '<li><a href="index.php?page=posts" data-page="posts">' . $view_files['posts']['icon'] . $view_files['posts']['title'] . '</a></li>';
				echo '<li class="active">' . $icons['edit'] . EDIT_ITEM . '</li>';
				break;

			case 'comments':
				echo '<li><a href="index.php?page=posts" data-page="posts">' . $view_files['posts']['icon'] . $view_files['posts']['title'] . '</a></li>';
				echo '<li class="active">' . $view_files['comments']['icon'] . $view_files['comments']['title'] . '</li>';
				break;

				case 'comment-create':
					echo '<li><a href="index.php?page=posts" data-page="posts">' . $view_files['posts']['icon'] . $view_files['posts']['title'] . '</a></li>';
					echo '<li><a href="index.php?page=comments&post-id=1" data-page="comments" data-params="post-id=1">' . $view_files['comments']['icon'] . $view_files['comments']['title'] . '</a></li>';
					echo '<li class="active">' . $icons['create'] . CREATE_ITEM . '</li>';
					break;

				case 'comment-edit':
					echo '<li><a href="index.php?page=posts" data-page="posts">' . $view_files['posts']['icon'] . $view_files['posts']['title'] . '</a></li>';
					echo '<li><a href="index.php?page=comments&post-id=1" data-page="comments" data-params="post-id=1">' . $view_files['comments']['icon'] . $view_files['comments']['title'] . '</a></li>';
					echo '<li class="active">' . $icons['edit'] . EDIT_ITEM . '</li>';
					break;

		case 'events':
			echo '<li class="active">' . $view_files['events']['icon'] . $view_files['events']['title'] . '</li>';
			break;

		default:
			echo '<li class="active">Der er ikke oprettet breadcrumb til denne side</li>';
	}
}