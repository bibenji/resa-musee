// Attention : ce fichier doit être implémenté en premier !
// FONCTIONS DE CALCUL LIVE DU COUT DE LA RESERVATION
var spanCoutTotal = $('.reservation-page-cout-total span');

function calculPrix(age, reduction, type) {
	var prix;
	if (age < 4) prix = 0;
	else if (reduction == 1) prix = 10;
	else if (age >= 4 && age < 12) prix = 8;
	else if (age >= 60) prix = 12;
	else prix = 16;
	
	if (type == 'H') prix /= 2;
	
	return prix;
}

function countPersonsAndTotalPrice() {
	var persons = $('.oneAddedPerson').get();
	var typeResa = $('.resa-type').val();				
	
	if (typeResa) {
		var total = 0;
		$.each( persons, function( key, elem ) {
			
			var selects = $( elem ).children('select');
			
			var age = selects[0].value;
			var reduction = selects[1].value;
			if (age && reduction) {										
				total += calculPrix(age, reduction, typeResa);
			}
			
		});
		spanCoutTotal.text(total);
	}				
}			

// bouton caché
$('#btn-to-count-total').click(function(e) {
	e.preventDefault();
	countPersonsAndTotalPrice();
});



// MISE EN PLACE DU DATEPICKER
$(function() {

// console.log(availableDates);

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

// fonction pour bloquer les jours de fermeture
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

// fonction pour bloquer les dates pleines
function checkIfNotFull(d) {
	var dateToCheck = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
	
	var result = $.inArray(dateToCheck, availableDates);
		
	if (result != -1) {		
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
		if (checkIfOpen(d) && checkIfNotFull(d)) {				
			return [true, ""];			
		}
		else {
			return [false, ""];
		}
	},
	
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: "" };
	
datepicker.setDefaults( datepicker.regional.fr );

return datepicker.regional.fr;

} ) );

// détection du jour sélectionné dans le datepicker
// et affichage d'un message selon le type de billet choisi		
$( '.datepicker' ).datepicker( $.datepicker.regional[ "fr" ] );

function checkDatepicker() {
	var datepickerDate = $('.datepicker').datepicker( "getDate" );
	
	if (datepickerDate) // = solution provisoire
	{
		var today = new Date();
		
		if (datepickerDate.getDate() == today.getDate() // si c'est le jour d'aujourd'hui
			&&
			datepickerDate.getMonth() == today.getMonth() // et le mois de ce mois-ci
			&&
			today.getHours() >= 13) // et qu'il est plus de 14h
		{						
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

	// initialisation des champs "info"	
	$('#type-info-1').hide();
	$('#type-info-2').hide();
	setTimeout(function() {
		checkDatepicker();
	}, 1000);
		
	$( '.datepicker' ).change(function() {
		checkDatepicker();			
	});	
		
	$('.resa-type').change(function() {
		countPersonsAndTotalPrice(); // mise à jour du prix total
		if ($(this).val() == "H") {
			$('#type-info-1').show();
		} else {
			$('#type-info-1').hide();
		}			
	});
	
});
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
Stripe.setPublishableKey('pk_test_ZpqFBfj36X6NW7TNYxGAVBwT');

function stripeResponseHandler(status, response) {

	var $form = $('#payment-form'); // Grab the form:

	if (response.error) { // Problem!

		// Show the errors on the form:
		$form.find('.payment-errors').html('<ul><li>'+response.error.message+'</li></ul>');
		$form.find('.submit').prop('disabled', false); // Re-enable submission

	} else { // Token was created!

		// Get the token ID:
		var token = response.id;

		// Insert the token ID into the form so it gets submitted to the server:
		$form.append($('<input type="hidden" name="stripeToken">').val(token));

		// Submit the form:
		$form.get(0).submit();
	}
};

$(function() {

	var $form = $('#payment-form');

	$form.submit(function(event) {

		// Disable the submit button to prevent repeated clicks:
		$form.find('.submit').prop('disabled', true);

		// Request a token from Stripe:
		Stripe.card.createToken($form, stripeResponseHandler);

		// Prevent the form from being submitted:
		return false;
	});
	
});