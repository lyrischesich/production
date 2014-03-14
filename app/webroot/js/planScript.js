/**
*	Plan-Script: Kann einfach alles
*	@author Johannes Graeger
*/
	$(document).ready(function() {
		
		$("#wahlmenu").dialog();

		$(".tderrorlink").click(function() {
			if ($(this).html() == "") {
				var cellID = $(this).attr('id');
				entryProcedure(cellID);
			}
		})

		
	function entryProcedure(cellID) {
		if(cellID.substr(0,3) == "txt") {
			//Es handelt sich um eine Textspalte
			//Das machen wir später! TODO
		} else {
			//Es handelt sich um eine Benutzerspalte
			
			var date = cellID.substr(0,10);
			buildMenue();
			$("#wahlmenue").dialog('open');

		}
	}

	function buildMenue() {
		$("#wahlmenu").dialog({ autoOpen: false, height: 250, width: 400, modal: true, buttons: { "Abbrechen": function() {$( this ).dialog( "close" );} }});
		$("#frei_y").button();
		$("#frei_n").button();
		$("#eintragen").button();
		$("#eintragenSwitch").buttonset();
		$("#austragen").button();
	}
});

