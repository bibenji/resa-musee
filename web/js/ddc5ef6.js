(function($) {
			
	// DATEPICKER			
	/*
	$('.js-datepicker').datepicker({
		format: 'yyyy-mm-dd',
		regional: 'fr',
	});
	*/
				
	// PERSONS
	// keep track of how many email fields have been rendered
	var personsCount = '{{ form.persons|length }}';
	var personsList = $('#persons-fields-list');
	
	$('#add-another-person').on('click', function(e) {
		e.preventDefault();
		addPerson();
	});
	
	function addPerson() {
		var newWidget = personsList.attr('data-prototype');
		// replace the "__name__" used in the id and name of the prototype
		// with a number that's unique to your emails
		// end name attribute looks like name="contact[emails][2]"
		newWidget = newWidget.replace(/__name__/g, personsCount);
		personsCount++;
		newWidget = 'Person '+personsCount+' :<br />'+newWidget;
		
		<!-- var newLi = $('<div class="oneAddedPerson"></div>').html(newWidget); -->
		var $newLi = $('<div class="oneAddedPerson"></div>').append(newWidget);
		
		$newLi.append('<a href="#" class="remove-person">Remove</a>');
		
		$newLi.appendTo(personsList);
		
		$('.remove-person').click(function(e) {
			e.preventDefault();
			$(this).parent().remove();
			<!-- console.log($(this).parent().parent()); -->
			
			return false;
		});
		
	}
		
		/*
		newDivToSuppr = document.createElement('div');
		newButtToSuppr = document.createElement('button');
		newButtToSuppr.innerHTML = 'XXX';
		newButtToSuppr.click(function() {
			removePerson();
		});
		newDivToSuppr.append(newButtToSuppr);				
		*/
}) (jQuery)		
	
