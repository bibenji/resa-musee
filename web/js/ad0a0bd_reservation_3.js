// Gère l'ajout de personnes à la réservation
(function($) {
		
	var personsCount = $('.oneAddedPerson').length;
	
	var personsList = $('#persons-fields-list');
	
	$('#add-another-person').on('click', function(e) {
		e.preventDefault();
		addPerson();
	});
	
	// fonction pour MAJ champs intervenant dans le calcul du prix total
	function updateSelectWatchers() {		
		var allSelects = $('#persons-fields-list').find('select');
		
		allSelects.change(function() {
			countPersonsAndTotalPrice();
		});
	}
	
	function updateBtnRemovePerson() {
		$('.removePerson').click(function(e) {
			e.preventDefault();
			$(this).parent().remove();
			countPersonsAndTotalPrice(); // mise à jour du prix
			return false;
		});
	}
	
	updateSelectWatchers(); // au chargement de la page
	updateBtnRemovePerson(); // au chargement de la page
	countPersonsAndTotalPrice(); // au chargement de la page
	
	function addPerson() {
		var newWidget = personsList.attr('data-prototype');		
		newWidget = newWidget.replace(/__name__/g, personsCount);
		personsCount++;		
				
		var $newPerson = $('<div class="oneAddedPerson"></div>').append(newWidget);				
		$newPerson.appendTo(personsList);
		
		updateSelectWatchers(); // remise à jour des selects à surveiller
		updateBtnRemovePerson(); // remise à jour des btn .removePerson à surveiller		
	}

}) (jQuery)