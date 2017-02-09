$(function() {
	
	$('.homepage-menu-btn').click(function(e) {				
		
		var page = $(this).attr('href'); // Page cible
		
		var speed = 750; // Durée de l'animation (en ms)
		
		$('html, body').animate({
			scrollTop: $(page).offset().top
		}, speed );
		
		return false;				
	});
	
});