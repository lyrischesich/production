/**
 * Plan-Script: Kann einfach alles
 * 
 * @author Johannes Graeger
 */
	
var method;
var loggedInAs;
var adminModeActive = false;

$(document).ready(function() {
	
	loggedInAs = $("#loggedInUserAnchor").html();

	$("#adminLinkAnchor").on('click',function() {
		activateAdminMode(!adminModeActive);
	});
	
	$("#planTable td").each(function() {
		if ($(this).hasClass("tdnonobligatedlink")) {
			if ($(this).html() == loggedInAs) {
				$(this).removeClass();
				$(this).addClass("tdnonobligatedbyuser");
			}
		}
	});
	
	$("#halfshift-btngroup").hide();
	
	//Alles für obligated Cells
	$("body").on('click',".tdsuccesslink, .tderrorlink",function() {
		var cellID = $(this).attr('id');
		var isNoWeekday = cellID.substr(0,3) != "dow";

		
		if (isNoWeekday) {
			if ($(this).hasClass("tderrorlink")) {
				openDialog(cellID,true);
			} else {
				openDialog(cellID,false);
			}
		}
	});

	//Alles für Textspalten
	$("body").on('click','td[id^="txt_"]',function() {
		alert("Not implemented yet!");
	});


	//Eventhandler für den Bestätigenknopf im regulären austragen Dialog
	$("#btnDialogConfirm").on('click',ajaxHandler);
});

function activateAdminMode(activate) {

	if (activate) {	
		adminModeActive = true;
		alert("Adminmodus aktiviert");
		$("body").off('click','td[id^="txt_"]');
		$("body").off('click',".tdsuccesslink, .tderrorlink");

		$("body").on('click',".tdsuccesslink, .tderrorlink",function() {
			var cellID = "textfield_" + $(this).attr('id');
			var newTextfield = $("<input type='text' id='"+cellID+"'></input>");
			$(this).html(newTextfield);
		});
	} else {
		alert("Adminmodus deaktiviert");
		adminModeActive = false;
		$("body").off('click','td[id^="txt_"]');
		$("body").off('click',".tdsuccesslink, .tderrorlink");

		$("body").on('click',".tdsuccesslink, .tderrorlink",function() {
			var cellID = $(this).attr('id');
			var isNoWeekday = cellID.substr(0,3) != "dow";

		
			if (isNoWeekday) {
				if ($(this).hasClass("tderrorlink")) {
					openDialog(cellID,true);
				} else {
					openDialog(cellID,false);
				}
			}
		});
	}

}

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
		var str = document.URL.split('plan');
			var requestUrl = str[0] + "plan/saveUserEntry/" + date + "/" + columnID + "/" + halfshift + "/";
		alert(requestUrl);
			
		if (username != "") requestUrl += username;
		$.ajax( {
			type: 'POST',
			url: requestUrl,
			data: "ajax=1",
			success: function(response) {
				if (response == "200") {
				  if (username == loggedInAs) {
					 $("#"+cellID).removeClass();
					 $("#"+cellID).addClass("tdsuccesslink");
					 $("#"+cellID).text(username);
				  }
						
				} else if (response == "210") {
					var splitted_id = cellID.split("_");
					var sel_shift = splitted_id[2];
					
					if (typeof sel_shift == 'undefined') {
						$("#"+cellID).text("");
						$("#"+cellID).removeClass("tdsuccesslink");
						$("#"+cellID).addClass("tderrorlink");
					} else if (sel_shift == "1") {
						var otherCellID = splitted_id[0] + "_" + splitted_id[1] + "_2";
						if ($("#"+otherCellID).hasClass("tderrorlink")) {
							var newCellID = splitted_id[0] + "_" + splitted_id[1];
							$("#"+cellID).remove();
							$("#"+otherCellID).attr('id',newCellID);
							$("#"+newCellID).attr('colspan',2);
						} else {
							$("#"+cellID).text("");
							$("#"+cellID).removeClass("tdsuccesslink");
							$("#"+cellID).addClass("tderrorlink");
						}
					} else if (sel_shift == "2") {
						var otherCellID = splitted_id[0] + "_" + splitted_id[1] + "_1";
						if ($("#"+otherCellID).hasClass("tderrorlink")) {
							var newCellID = splitted_id[0] + "_" + splitted_id[1];
							$("#"+otherCellID).attr('colspan',"2");
							$("#"+otherCellID).attr('id',newCellID);
							$("#"+cellID).remove();
						} else {
							$("#"+cellID).text("");
							$("#"+cellID).removeClass("tdsuccesslink");
							$("#"+cellID).addClass("tderrorlink");
						}
					}

				} else {
					alert ("Unknown response code: " + response);
				}
				
				//Es wurde in jedem Fall eine Änderung vorgenommen (Egal ob erfolgreich oder nicht), daher wird der Wochentag auf vollständigkeit überprüft
				
					var validationUrl = str[0] + "plan/datecomplete/" + date;

				
				$.ajax( {
					type: 'POST',
					data: "ajax=1",
					url: validationUrl,
					error: function(response) {
						alert("Ein Fehler ist aufgetreten. Bitte laden sie die Seite erneut.");
					},
					success: function(response) {
						$("#dow_"+date).removeClass();
						if (response == "true") {
							$("#dow_"+date).addClass("tdsuccess");
						} else {
							$("#dow_"+date).addClass("tderrorlink");
						}
					}
						
				});
			},
			error: function(response) {
				alert ("Unbekannter Fehler");
			}

		});
	}
$("#btnDialogConfirm").button('reset');
$("#modalMenu").modal('hide');
$("#halfshift-btngroup").show();
return false;
}

	
	function openDialog(cellID,eintragen) {
			$("#btn-first").removeClass('active');
			$("#btn-first").show();
			$("#btn-second").removeClass('active');
			$("#btn-second").show();
			$("#btn-full").removeClass('active');
			$("#btn-full").show();
			
			$("#methodAnchor").html("");
			$("#dateAnchor").html("");
			$("#shiftAnchor").html("");
			
			
			if (cellID.substr(0, 3) == "txt") {
				// Es handelt sich um eine Textspalte
				// Das machen wir später! TODO
			} else {
				// Es handelt sich um eine Benutzerspalte
				if (eintragen) {
					$("#methodAnchor").html("Eintragen");
					//Es sollen nur Optionen angezeigt werden, welche zutreffen
					if (typeof cellID.split("_")[2] != 'undefined') {
						$("#halfshift-btngroup").hide();
						var lastChar = cellID.charAt(cellID.length -1);
						if (lastChar == "1") {
							$("#btn-first").addClass('active');
							$("#btn-full").hide();
							$("#btn-second").hide();
						}
						if (lastChar == "2") {
							$("#btn-second").addClass('active');
							$("#btn-full").hide();
							$("#btn-first").hide();
						}
					} else {
						$("#btn-full").addClass('active');
					}
					$("#modalMenuLabel").html("Eintragen");
					$("#btnDialogConfirm").html("Eintragen");
					method = "in";
					$("#halfshift-btngroup").show();
				} else {
					//Hier geht es jetzt ums austragen
					$("#methodAnchor").html("Austragen");
					$("#modalMenuLabel").html("Austragen");
					$("#btnDialogConfirm").html("Austragen");
					method = "out";
					$("#halfshift-btngroup").hide();
				}
				var formatDate = new Date(cellID.substr(0,10));
				$("#dateAnchor").html(formatDate.getDate() + "." + (formatDate.getMonth()+1) + "." + formatDate.getFullYear());
				
				//Finde den TableHeader zu der entsprechenden Schicht:
				var $td = $("#"+cellID);
				var $th = $td.closest('table').find('th').eq($td.index());
				$("#shiftAnchor").html($th.html());
						
				$("#cellID").val(cellID);
				$("#modalMenu").modal('show');
			}
		}
