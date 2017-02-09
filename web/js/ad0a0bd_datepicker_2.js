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