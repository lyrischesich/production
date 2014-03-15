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
				$("#cellID").val(cellID);
				$("#modalMenu").modal('show');
			}
		}
	});

	
	//Eventhandler für den Bestätigenknopf im regulären austragen Dialog
	$("#btnDialogConfirm").click(function() {
		$(this).button('loading');
		var cellID = $("#cellID").val();
		if (cellID == '') {
			alert("Fehlercode #01 \n Bitte versuchen sie es erneut");
		} else {
			var username = $("#usernameHidden").val();
			var date = cellID.substr(0,10);
			var halfshift = $("#halfshift-btngroup").find("button.active").prop('value');
			var columnID = cellID.split("_")[1];
			var requestUrl = window.location.pathname + "/saveUserEntry/" + date + "/" + columnID + "/" + halfshift + "/" + username;	
			
//			var submitData = "date=" + date + "&columnid=" + columnID + "&halfshift=" + halfshift + "&username=" + username;
			
			$.ajax( {
				type: 'POST',
				url: requestUrl,
				data: "ajax=1",
				success: function(response) {
					if (response == "200") {
						$("#modalMenu").modal('hide');
						$("#"+cellID).text(username);
						$("#"+cellID).toggleClass("tdsuccesslink");
					} else {
						alert ("Unknown response code" + response);
					}
				},
				error: function(response) {
					
				}

			});
		}
	return false;
	});
});
