/**
 * Plan-Script: Kann einfach alles
 * 
 * @author Johannes Graeger
 */
	
var method;

$(document).ready(function() {

	
	$("#halfshift-btngroup").hide();
	
	$("body").on('click',".tdsuccesslink, .tderrorlink",function() {
		var cellID = $(this).attr('id');
		
		if ($(this).hasClass("tderrorlink")) {
			openDialog(cellID,true);
		} else {
			openDialog(cellID,false);
		}
	});


	
	//Eventhandler für den Bestätigenknopf im regulären austragen Dialog
	$("#btnDialogConfirm").on('click',ajaxHandler);
	
	
	function openDialog(cellID,eintragen) {
			if (cellID.substr(0, 3) == "txt") {
				// Es handelt sich um eine Textspalte
				// Das machen wir später! TODO
			} else {
				// Es handelt sich um eine Benutzerspalte
				if (eintragen) {
					$("#modalMenuLabel").html("Eintragen");
					$("#btnDialogConfirm").html("Eintragen");
					method = "in";
					$("#halfshift-btngroup").show();
				} else {
					//Hier geht es jetzt ums austragen
					$("#modalMenuLabel").html("Austragen");
					$("#btnDialogConfirm").html("Austragen");
					method = "out";
					$("#halfshift-btngroup").hide();
				}
				$("#cellID").val(cellID);
				$("#modalMenu").modal('show');
			}
		}
});

function ajaxHandler() {
	var username;

	$("#btnDialogConfirm").button('loading');
	var cellID = $("#cellID").val();
	if (cellID == '') {
		alert("Fehlercode #01 \n Bitte versuchen sie es erneut");
	} else {
		
		var date = cellID.substr(0,10);
		var columnID = cellID.split("_")[1];
		var halfshift;

		if (method == "in") {
			username = $("#usernameHidden").val();
			halfshift = $("#halfshift-btngroup").find("button.active").prop('value');
		} else {
			var username = "";
			if (typeof cellID.split("_")[2] != 'undefined') {
				halfshift = cellID.split("_")[2];
			} else {
				halfshift = "3";
			}
		}
		
		var requestUrl = document.URL + "/saveUserEntry/" + date + "/" + columnID + "/" + halfshift + "/";
		if (username != "") requestUrl += username;
		$.ajax( {
			type: 'POST',
			url: requestUrl,
			data: "ajax=1",
			success: function(response) {
				if (response == "200") {
					var sel_shift = cellID.split("_")[2];
					if (typeof sel_shift == 'undefined') {
						if (halfshift == "3") {
							//Es gab vorher keine Halbschicht und es wird auf keine geben
							$("#"+cellID).removeClass("tderrorlink");
							$("#"+cellID).addClass("tdsuccesslink");
							$("#"+cellID).text(username);
						} else if (halfshift == "1") {
							//Es gab vorher keine Halbschicht, jetzt wird die erste belegt
							var newCellID = cellID + "_1";
							var secondCellID = cellID + "_2";
							$("#"+cellID).attr('id',newCellID);
							$("#"+newCellID).attr('colspan',1);
							$("#"+newCellID).removeClass("tderrorlink");
							$("#"+newCellID).addClass("tdsuccesslink");
							$("#"+newCellID).text(username);
							
							var scdCell = $("<td id='"+ secondCellID + "' class='tderrorlink' ></td>");
							$("#"+newCellID).after(scdCell);
						} else if (halfshift == "2") {
							//Es gab vorher keine Halbschicht, jetzt wird die zweite belegt
							var newCellID = cellID + "_1";
							var secondCellID = cellID + "_2";
							var cellString = "<td id='"+ secondCellID + "' class='tdsuccesslink' >"+username+"</td>";
							var scdCell = $(cellString);
							$("#"+cellID).attr('id',newCellID);
							$("#"+newCellID).attr('colspan',1);
							
							$("#"+newCellID).after(scdCell);
						}
					} else if (sel_shift == '1') {
						if (halfshift == "3") {
							//Es gab vorher eine Halbschicht rechts, jetzt übernimmt einer die ganze
							var splittedID = cellID.split("_");
							var newCellID = splittedID[0] + "_" + splittedID[1];
							var otherID = newCellID + "_2";
							$("#"+cellID).remove();							
							$("#"+otherID).attr('id',newCellID);
							$("#"+newCellID).attr('colspan',2);
						}
					}

				} else if (response == "210") {
					$("#modalMenu").modal('hide');
					$("#"+cellID).text("");
					$("#"+cellID).removeClass("tdsuccesslink");
					$("#"+cellID).addClass("tderrorlink");
				} else {
					alert ("Unknown response code: " + response);
				}

			},
			error: function(response) {
				alert ("Unbekannter Fehler");
			}

		});
	}
$("#btnDialogConfirm").button('reset');
$("#modalMenu").modal('hide');
return false;
}
