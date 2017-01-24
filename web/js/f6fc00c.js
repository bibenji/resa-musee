/* French initialisation for the jQuery UI date picker plugin. */
/* Written by Keith Wood (kbwood{at}iinet.com.au),
			  Stéphane Nahmani (sholby@sholby.net),
			  Stéphane Raimbault <stephane.raimbault@gmail.com> */
( function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define( [ "../widgets/datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}( function( datepicker ) {

function checkIfOpen(d) {
	// fermé les mardis
	// fermé le 1er mai
	// fermé le 11 novembre
	// fermé le 25 décembre
	if (
		d.getDay() == 2
		|| d.getDate() == 1 && d.getMonth() == 4
		|| d.getDate() == 11 && d.getMonth() == 10
		|| d.getDate() == 25 && d.getMonth() == 11
		|| d.getDate() == minDate.getDate() && d.getDate() == minDate.getMonth() && d.getHours() >= 17 // si nous sommes aujourd'hui mais qu'il est plus de 18h
	) {
		return false;
	} else {
		return true;
	}
}

var minDate = new Date();
while (!checkIfOpen(minDate)) {
	minDate.setDate(minDate.getDate() + 1);
}

datepicker.regional.fr = {
	closeText: "Fermer",
	prevText: "Précédent",
	nextText: "Suivant",
	currentText: "Aujourd'hui",
	monthNames: [ "janvier", "février", "mars", "avril", "mai", "juin",
		"juillet", "août", "septembre", "octobre", "novembre", "décembre" ],
	monthNamesShort: [ "janv.", "févr.", "mars", "avr.", "mai", "juin",
		"juil.", "août", "sept.", "oct.", "nov.", "déc." ],
	dayNames: [ "dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi" ],
	dayNamesShort: [ "dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam." ],
	dayNamesMin: [ "D","L","M","M","J","V","S" ],
	weekHeader: "Sem.",
	dateFormat: "dd/mm/yy",
	minDate: minDate,	
	firstDay: 1,
	
	beforeShowDay: function(d) {
		if (checkIfOpen(d))
			return [true, ""];
		else
			return [false, ""];		
		
		/*
		var dmy = (d.getMonth()+1); 
		
		if(d.getMonth()<9) 
			dmy="0"+dmy; 
			dmy+= "-"; 

		if(d.getDate()<10) dmy+="0"; 
			dmy+=d.getDate() + "-" + d.getFullYear(); 

		console.log(dmy+' : '+($.inArray(dmy, availableDates)));

		if ($.inArray(dmy, availableDates) != -1) {
			return [true, "","Available"]; 
		} else {
			return [false,"","unAvailable"]; 
		}
		*/
	},
	
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: "" };
datepicker.setDefaults( datepicker.regional.fr );

return datepicker.regional.fr;

} ) );
$(function() {
		
	$( '.datepicker' ).datepicker( $.datepicker.regional[ "fr" ] );
	
	function checkDatepicker() {
		var datepickerDate = $('.datepicker').datepicker( "getDate" );
		
		if (datepickerDate.getDate()) // = solution provisoire
		{
			var today = new Date();
			
			if (datepickerDate.getDate() == today.getDate() // si c'est le jour d'aujourd'hui
				&&
				datepickerDate.getMonth() == today.getMonth() // et le mois de ce mois-ci
				&&
				today.getHours() >= 13) // et qu'il est plus de 14h
			{
				// alert($('#datepicker').datepicker( "getDate" ));
				// $('#type option[value="F"]').attr('disabled','disabled').siblings().attr('selected','selected');
				// $('.resa-type option[value="H"]').prop('selected', true);			
				$('.resa-type option[value="F"]').removeAttr('selected');			
				$('.resa-type option[value="H"]').prop('selected', true);
				$('.resa-type option[value="F"]').attr('disabled','disabled');
				
				$('#type-info-2').show();
				$('#type-info-1').hide();
			} else {
				$('.resa-type option[value="F"]').removeAttr('disabled');
				$('.resa-type option[value="H"]').removeAttr('selected');
				$('.resa-type option[value="F"]').prop('selected', true);
				
				$('#type-info-2').hide();
				$('#type-info-1').hide();
			}				
		} else {
			var minDate = $('.datepicker').datepicker( "option", "minDate" ); 
			console.log(minDate);
		}
	}
	
		
	
	$('#type-info-1').hide();
	$('#type-info-2').hide();
	setTimeout(function() {
		checkDatepicker();
	}, 1000);
	
	$( '.datepicker' ).change(function() {
		checkDatepicker();			
	});	
	
	$('.resa-type').change(function() {
		if ($(this).val() == "H") {
			$('#type-info-1').show();
		} else {
			$('#type-info-1').hide();
		}			
	});
	
	
	
	// $( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
	// $( "#datepicker" ).datepicker( "option", "beforeShowDay", function(date) { });
	/*
	$( "#datepicker" ).datepicker({
		// dateFormat: 'dd-mm-yy',
		// minDate: new Date(), 			
	});
	*/  
	/*
	$( "#datepicker" ).datepicker({
		altField: "#datepicker",
		closeText: 'Fermer',
		prevText: 'PrÃ©cÃ©dent',
		nextText: 'Suivant',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier', 'FÃ©vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'AoÃ»t', 'Septembre', 'Octobre', 'Novembre', 'DÃ©cembre'],
		monthNamesShort: ['Janv.', 'FÃ©vr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'AoÃ»t', 'Sept.', 'Oct.', 'Nov.', 'DÃ©c.'],
		dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
		dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
		dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
		weekHeader: 'Sem.',
		dateFormat: 'yy-mm-dd'
		});
	});
	// var firstDay = $( "#datepicker" ).datepicker( "option", "firstDay" ); // marche pas
	$( "#datepicker" ).datepicker( "option", "firstDay", 1 ); // premier jour Ã  lundi
	// $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] ); // texte en french marche pas
	$(function() {
		$( "#datepicker" ).datepicker();
	*/
	
});
(function($) {
				
	// PERSONS
	// keep track of how many email fields have been rendered
	var personsCount = $('.oneAddedPerson').length;
	
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
	