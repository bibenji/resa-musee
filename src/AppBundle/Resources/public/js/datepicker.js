$(function() {
		
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
		prevText: 'Précédent',
		nextText: 'Suivant',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
		monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
		dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
		dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
		dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
		weekHeader: 'Sem.',
		dateFormat: 'yy-mm-dd'
		});
	});
	// var firstDay = $( "#datepicker" ).datepicker( "option", "firstDay" ); // marche pas
	$( "#datepicker" ).datepicker( "option", "firstDay", 1 ); // premier jour à lundi
	// $.datepicker.setDefaults( $.datepicker.regional[ "fr" ] ); // texte en french marche pas
	$(function() {
		$( "#datepicker" ).datepicker();
	*/
	
});