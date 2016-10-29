$(function() {
	$(".navbar-expand-toggle").click(function() {
		$(".app-container").toggleClass("expanded");
		return $(".navbar-expand-toggle").toggleClass("fa-rotate-90");
	});

	return $(".navbar-right-expand-toggle").click(function() {
		$(".navbar-right").toggleClass("expanded");
		return $(".navbar-right-expand-toggle").toggleClass("fa-rotate-90");
	});
});

$(function() {
	return $('.match-height').matchHeight();
});

$(function() {
	return $(".side-menu .nav .dropdown").on('show.bs.collapse', function() {
		return $(".side-menu .nav .dropdown .collapse").collapse('hide');
	});
});

$(function() {
	function load_plugins() {
		$('[data-toggle="confirmation"]').confirmation({
			placement		: 'auto left',
			singleton		: true,
			popout			: true,
			copyAttributes	: 'data-href data-params',
			btnOkLabel		: 'Bekræft',
			btnCancelLabel	: 'Annuller'
		});

		$('.toggle-checkbox').bootstrapSwitch({
			size	: 'mini',
			onColor	: 'success',
			offColor: 'danger',
			onText	: '<i class="fa fa-check" aria-hidden="true"></i>',
			offText	: '<i class="fa fa-times" aria-hidden="true"></i>'
		});

		// When we toggle checkbox with class .toggle-checkbox, do this (checkbox is replaced with bootstrapSwitch)
		$('.toggle-checkbox').on('switchChange.bootstrapSwitch', function(event, state) {
			// Save the toggled item in the variable $this, to access it after success in the ajax request
			var $this		= $(this),
				// Save data from the clicked item to a json object, that can be passed through the ajax request
				data_object	=
				{
					'status'	: state,
					'type'		: $this.data('type'),
					'id'		: $this.attr('id')
				};

			// Do ajax request to toggle_status.php, send the data_object as data and use post. Return the data from the php-file as json.
			$.ajax({
				type	: 'post',
				url		: 'includes/toggle_status.php',
				data	: data_object,
				dataType: 'json',
				success : function (response) { // On success, check if the returned status is false. If it is, return state to the previous
					if ( !response.status ) $this.bootstrapSwitch('state', !state, 'skip');
				}
			})
		});

		$('.select2').select2({
			width: '100%',
			"language": {
				"noResults": function(){
					return "Ingen resultater fundet";
				}
			}
		});

		var sortable_cache = $('#sortable').html();
		$('#sortable').sortable({
			items	: '.sortable-item', // Element med denne klasse er det der flyttes på
			handle	: '.sortable-handle', // Element med denne klasse bruges til at trække i
			distance: 5, // Træk mere end 5 pixels før det sorteres
			update	: function() {
				var data_array	= []; // opretter et tom array
				$('.sortable-item').each(function(index) { //for hvert ting i id'et sortable med class sortable-item kører vi en funktion med index (nummer fra 0-XX)
					data_array[index] = {id: $(this).attr('id')}; // Tilføj id'et fra hvert element til et array

					// Opdatér sorteringsnummeret i første kolonne
					$('#' + $(this).attr('id') + ' td:first-child').text(index + 1);
				});

				var data_object =
				{
					type	: $(this).data('type'),
					section	: $(this).data('section'),
					data	: data_array
				};

				// Do ajax request to sortable.php, send the data_object as data and use post. Return the data from the php-file as json.
				$.ajax({
					type	: 'post',
					url		: 'includes/sortable.php',
					data	: data_object,
					dataType: 'json',
					success : function (response) { // On success, check if the returned status is false. If it is, return order to the previous
						if ( !response.status )
						{
							$('#sortable').html(sortable_cache);
						}
					}
				})
			}
		});

		prettyPrint();
	}


	load_plugins();

	/**
	 * Function to load a breadcrumb with the ajax get-request
	 * @param page (string): the filename without file extension from the view folder
	 * @param params (URL encoded string): The params to pass in URLs query string (e.g. id=1)
	 */
	function load_breadcrumb(page, params) {
		// Send request to breadcrumb.php with URL encoded data (e.g. page=some-page&id=1)
		$.get( 'includes/breadcrumb.php', 'page=' + page + ( params != '' ? '&' + params : '') )
			.done( function (response) { // On success, run function with returned content saved in response
				$("#breadcrumb").html(response); // Add content from response as HTML to the element with the id breadcrumb
			})
	}

	/**
	 * Function to load a page with an ajax request
	 * @param page (string): the filename without file extension to load from the view folder
	 * @param params (URL encoded string): The params to pass in URLs query string (e.g. id=1)
	 * @param data (URL encoded string): Optional data to pass to the file (e.g. name=Some-Name&description=Some-Description)
	 * @param method (post || get): Optional set method to post, default method is get
	 */
	function load_content(page, params, data, method) {
		$('.modal').modal('hide'); // If any Bootstrap modals is toggled, hide them
		$('body').removeClass('modal-open'); // If any Bootstrap modals is toggled, remove the class modal-open from the body-tag
		$('.modal-backdrop').remove(); // If any Bootstrap modals is toggled, remove the element with the class .modal-backdrop

		var content		= $("#main-content"), // Select the element to load content to (here with the id: main-content) and save it to content
			nav_items	= $('.nav.navbar-nav li'), // Select all elements in the navigation to add or remove the class active (here li in the ul with the classes nav and navbar-nav and save it to nav_items
			file_path	= 'view/' + page + '.php' + ( params != '' ? '?' + params : ''); // Generate path to file to load. Prefix the page name with the folder view/ and add the file-extension .php and params if any defined

		content.parent('.container-fluid').addClass('loader'); // Add the class loader to the contents parent with the class .container-fluid

		$.ajax({
			type	: typeof method !== 'undefined' ? method : 'get', // If method is defined use this value or use get
			url		: file_path, // Set url to the file_path generated a few lines up
			data	: typeof data !== 'undefined' ? data : '', // If data is passed to the function send that, and if not send empty string
			success	: function(response) { // On success, run function with returned content saved in response
				content.html(response).attr('data-content', page); // Add content from response as HTML to the content element and add the attribute data-content with the current page
				load_plugins(); // Run the function load_plugins() to use them on the new content not added to the DOM
				load_breadcrumb(page, params); // Run the function load_breadcrumb() and pass the values from page and params to show the breadcrumb to the new page loaded
				content.parent('.container-fluid').removeClass('loader'); // Now the new content is loaded, so remove the class loader from the content element
				nav_items.removeClass('active'); // Remove the active class from any item in the navigation
				nav_items.each( function() { // Loop through all items in the navigation
					// If the link inside the item has a value in the attribute data-page that matches the current page, add the class active
					if ($(this).find('a').data('page') == page) $(this).addClass('active');
				})
			},
			error	: function(xhr) { // On error (when no page was found), run function and catch xhr data
				load_content('error', 'status=' + xhr.status); // Rerun this function and set page to 'error' and params to status=404 or the number in xhr.status
			}
		});
	}

	// Run this when a link with the attribute data-page is clicked
	$(document.body).delegate('a[data-page]', 'click', function(e) {
		// Prevent the default click event, where the page refreshes
		e.preventDefault();
		var page		= $(this).data('page'), // Save the value from the links attribute data-page to page
			params		= $(this).data('params') ? $(this).data('params') : ''; // If data-params is defined, save the value to params or set empty
		history.pushState({}, null, $(this).attr('href')); // Update the current URL with the value from the attribute href
		load_content(page, params); // Run the function load_content() and pass the values from the variables page and params
	});

	// Run this when a form with the attribute data-page is submitted
	$(document.body).delegate('form[data-page]', 'submit', function(e) {
		// Prevent the default form submit, where the page refreshes
		e.preventDefault();
		var method		= $(this).attr('method') ? $(this).attr('method') : 'get', // If the attribute method is defined on the form, save the value to method or set to get
			page		= $(this).data('page'), // Save the value from the forms attribute data-page to page
			data		= $(this).serialize(), // URL encode the form elements (such as input, textarea and select) as a string
			submit_btn	= $(this).find('[type=submit]:focus'); // Find the forms submit button

		data += submit_btn.attr('name') ? '&' + submit_btn.attr('name') + '=' + submit_btn.val() : ''; // If a name and value is defined on the submit button, append it to the data string

		var	params		= method == 'post' ? ($(this).data('params') ? $(this).data('params') : '') : data.replace('page=' + page + '&', ''), // If the method is set to post, only take the params from the forms attribute data-params. If method is get, save the data string in params and remove &page=some-file from the data string.
			href		= page == 'index' ? '' : 'index.php?page=' + page + ( params != '' ? '&' + params : ''); // If the page to load is index, set href empty, and if not generate the URL with the page to load and append the params if any
		history.pushState({}, null, href); // Update the current URL with the value from href
		load_content(page, params, method == 'post' ? data : '', method); // Run the function load_content() and pass the values from the variables page, params and method. Ony pass the value from data if method is post, because when method is get, the data from the form is appended to params
	});

	// Run this when an option in a select with the attribute data-change"submit-form" is changed
	$(document.body).delegate('select[data-change="submit-form"]', 'change', function() {
		// Submit the form with this select inside
		$(this).parents('form').submit();
	});

	// Function to get the value from a URL parameter, works like $_GET in PHP
	function getQueryVariable(variable) {
		var query = window.location.search.substring(1);
		var vars = query.split("&");
		for (var i=0;i<vars.length;i++) {
			var pair = vars[i].split("=");
			if(pair[0] == variable){return pair[1];}
		}
		return(false);
	}

	// Run this when a popstate event is triggered (change in history, click on back or forward button in the browser)
	$(window).bind("popstate", function() {
		var page	= getQueryVariable('page'), // Use function to get the value for page from the current URL, to know wich page to load
			params	= ''; // Define params with empty value

		// If page is not false, do this
		if (page !== false)
			// Take the substring / query string form the current URL and remove page=some-file& from the params, beacuse we have that value in page.
			params	= location.search.substring(1).replace('page=' + page + '&', '');
		// If the page is false, no value was found for page in the current URL, so set page to index
		else
			page = 'index';

		load_content(page, params); // Run the function load_content() and pass the values from the variables page and params
	});


	/*// If there's a instance of CKeditor, we update the matching textareas when content is changed.
	if ( typeof(CKEDITOR) != 'undefined')
	{
		$.each( CKEDITOR.instances, function(instance) {
			CKEDITOR.instances[instance].on('blur', function() {
				var sel = $('#'+instance);
				CKEDITOR.instances[instance].updateElement();
				sel.trigger('change');
			});
		});
	}*/

	// If an option in the select with the id content_type is changed, do this (is on form-page-content.php)
	$(document.body).on('change', '#content_type', function() {
		var item	= $(this),
			value	= item.val();

		if (value == 1) { // If the selected option is 1 (Editor), do this
			$('#1').show(); // Show the input to description and the textarea/ckeditor to the content
			$('#2').hide(); // Hide the select to page-function
			$('#1 #description').attr('required', true); // Add the attribute required on the description
			$('#2 #page_function').attr('required', false); // Remove the attribute required on the select for page-function
		} else { // If the selected option is not 1, do this
			$('#1').hide(); // Hide the input to description and the textarea/ckeditor to the content
			$('#2').show(); // Show the select to page-function
			$('#1 #description').attr('required', false); // Remove the attribute required on the description
			$('#2 #page_function').attr('required', true); // Add the attribute required on the select for page-function
		}
	});

	// If an option in the select with the id link_type is changed, do this (is on form-menu-link.php)
	$(document.body).on('change', '#link_type', function() {
		var item	= $(this),
			value	= item.val();

		if (value == 2) { // If the selected option is 2 (Blog post), do this
			$('#2').show(); // Show the select with posts
			$('#2 #post').attr('required', true); // Add the attribute required on the select with posts
			$('#3').hide(); // Hide the input to bookmark
			$('#3 #bookmark').attr('required', false); // Remove the attribute required on the input bookmark
		} else if (value == 3) {
			$('#2').hide(); // Hide the select with posts
			$('#2 #post').attr('required', false); // Remove the attribute required on the select with posts
			$('#3').show(); // Show the input to bookmark
			$('#3 #bookmark').attr('required', true); // Add the attribute required on the input bookmark
		} else {
			$('#2').hide(); // Hide the select with posts
			$('#2 #post').attr('required', false); // Remove the attribute required on the select with posts
			$('#3').hide(); // Hide the input to bookmark
			$('#3 #bookmark').attr('required', false); // Remove the attribute required on the input bookmark
		}
	});

	// If there's change in the checkbox with the id link_to_page, do this
	$(document.body).on('change', '#link_to_page', function () {
		// If the checkbox is checked...
		if ( $(this).prop('checked') )
		{
			$('#menu_link').show(); // Show the checkboxes for menu and the input for link name
			$('#menu_link #page').attr('required', true); // Add required to the select for page
			$('#menu_link #link_name').attr('required', true); // Add required to the input for link name
		}
		// If the checkbox is not checked...
		else
		{
			$('#menu_link').hide(); // Hide the checkboxes for menu and the input for link name
			$('#menu_link #page').attr('required', false); // Remove required to the select for page
			$('#menu_link #link_name').attr('required', false); // Remove required from the input for link name
		}
	})
});
