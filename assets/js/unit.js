jQuery(function() {
	$('.expand').click(function(e) {
		$(this).parents('.test-suite').find('.tests').slideToggle();
	});

	$('.buttons .trace').click(function(e) {
		var $details = $(this).parents('.test').find('.details');
		$details.find('.trace-panel').slideToggle();
		$details.find('.output').hide();
	});

	$('.buttons .output').click(function(e) {
		var $details = $(this).parents('.test').find('.details');
		$details.find('.output-panel').slideToggle();
		$details.find('.trace-panel').hide();
	});

	$('.minus').click(function(e) {
		$(this).parents('.trace').toggleClass('expanded').toggleClass('collapsed');
		$('this').toggleClass()
	});

	$('.plus').click(function(e) {
		$(this).parents('.trace').toggleClass('expanded').toggleClass('collapsed');
	});
});