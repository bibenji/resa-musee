(function($) {
				
	// PERSONS
	// keep track of how many email fields have been rendered
	var personsCount = $('.oneAddedPerson').length;
	
	var personsList = $('#persons-fields-list');
	
	$('#add-another-person').on('click', function(e) {
		e.preventDefault();
		addPerson();
	});
	
	function updateBtnRemovePerson() {
		$('.removePerson').click(function(e) {
			e.preventDefault();
			$(this).parent().remove();
			return false;
		});
	}
	
	updateBtnRemovePerson();
	
	function addPerson() {
		var newWidget = personsList.attr('data-prototype');
		// replace the "__name__" used in the id and name of the prototype
		// with a number that's unique to your emails
		// end name attribute looks like name="contact[emails][2]"
		newWidget = newWidget.replace(/__name__/g, personsCount);
		personsCount++;		
				
		var $newPerson = $('<div class="oneAddedPerson"></div>').append(newWidget);				
		$newPerson.appendTo(personsList);
		
		updateBtnRemovePerson();		
	}

}) (jQuery)		
	