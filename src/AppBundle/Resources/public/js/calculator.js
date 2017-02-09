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


