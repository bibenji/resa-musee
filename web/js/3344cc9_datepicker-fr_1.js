/* French initialisation for the jQuery UI date picker plugin. */
/* Written by Keith Wood (kbwood{at}iinet.com.au),
			  St�phane Nahmani (sholby@sholby.net),
			  St�phane Raimbault <stephane.raimbault@gmail.com> */
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
	// ferm� les mardis
	// ferm� le 1er mai
	// ferm� le 11 novembre
	// ferm� le 25 d�cembre
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
if (!checkIfOpen(minDate)) {
	minDate.setDate(minDate.getDate() + 1);
}

datepicker.regional.fr = {
	closeText: "Fermer",
	prevText: "Pr�c�dent",
	nextText: "Suivant",
	currentText: "Aujourd'hui",
	monthNames: [ "janvier", "f�vrier", "mars", "avril", "mai", "juin",
		"juillet", "ao�t", "septembre", "octobre", "novembre", "d�cembre" ],
	monthNamesShort: [ "janv.", "f�vr.", "mars", "avr.", "mai", "juin",
		"juil.", "ao�t", "sept.", "oct.", "nov.", "d�c." ],
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