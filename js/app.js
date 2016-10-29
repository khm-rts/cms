$(function() {
	$('.match-height').matchHeight();

	$('body').scrollspy({
		target: '#main-nav',
		offset: 70
	});

	$('[data-spy="scroll"]').each(function () {
		var $spy = $(this).scrollspy('refresh')
	});

	// Add smooth scrolling on anchors inside the navbar
	$(document.body).on('click', 'a[href*="#"]:not([href="#"])', function(e) {
		// Store hash and href
		var hash	= this.hash;

		// Make sure the element exist on the current page
		if ( $(hash).length ) {
			// Prevent default anchor click behavior
			e.preventDefault();
			// Using jQuery's animate() method to add smooth page scroll
			// The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
			$('html, body').animate({
				scrollTop: $(hash).offset().top - 68
			}, 800, function() {
				// Add hash (#) to URL when done scrolling (default click behavior)
				window.location.hash = hash;
			});
		}
	});
});