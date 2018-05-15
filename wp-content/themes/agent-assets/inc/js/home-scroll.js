jQuery(document).ready(function($) {
	$(".site-intro").addClass("animated zoomInDown");
	$(window).scroll(function() {
		if ($(document).scrollTop() > 1) {
			$(".site-title").addClass("animated jello");
		} else {
			$(".site-title").removeClass("animated jello");
		}
	});
	$(window).scroll(function() {
		if ($(document).scrollTop() > 5 ) {
			$(".site-intro").addClass("animated zoomOutLeft");
		} else {
			$(".site-intro").removeClass("animated zoomOutLeft");
			$(".site-intro").addClass("animated bounceInLeft");
		}
	});
});
