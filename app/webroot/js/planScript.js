/**
 * Plan-Script: Kann einfach alles
 * 
 * @author Johannes Graeger
 */
$(document).ready(function() {
	$(".tderrorlink").click(function() {
		if ($(this).html() == "") {
			var cellID = $(this).attr('id');
			openDialog(cellID);
		}

		function openDialog(cellID) {
			if (cellID.substr(0, 3) == "txt") {
				// Es handelt sich um eine Textspalte
				// Das machen wir später! TODO
			} else {
				// Es handelt sich um eine Benutzerspalte
				$("#modalMenuLabel").html("Eintragen");
				$("#btnDialogConfirm").html("Eintragen");
				$("#cellID").html(cellID);
				$("#modalMenu").modal('show');
			}
		}
	});
	
	$("#btnDialogConfirm").click(function() {
		var cellID = $("#cellID").text();
		if (cellID == '') {
			alert("Fehlercode #01 \n Bitte versuchen sie es erneut");
		} else {
			
		}
	});
});
