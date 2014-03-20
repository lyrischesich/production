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

	$("#adminLinkAnchor").on('click',function(event) {
		event.preventDefault();
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
	
	$("body").on('click',".tdsuccesslink, .tderrorlink, .tdnonobligatedbyuser, .tdnonobligatedlink",function() {
		var cellID = $(this).attr('id');
		var isNoWeekday = cellID.substr(0,3) != "dow";

		
		if (isNoWeekday) {
			if ($(this).hasClass("tderrorlink") || $(this).hasClass("tdnonobligatedlink")) {
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
	var today = new Date();
	
	if (activate) {	
		adminModeActive = true;
		alert("Adminmodus aktiviert");
		var today = new Date();
		$("td").each(function() {
			var cellID = $(this).attr("id");
			if (typeof cellID != "undefined") {
				var cellDate = new Date(cellID.split('_')[0]);
				if (cellDate > today && $("#"+cellID).hasClass("tdsuccess")) {
					$("#"+cellID).removeClass();
					$("#"+cellID).addClass("tdsuccesschangeable");
				}
			}
		});
		$("body").off('click');
		$("body").on('click',".tdsuccesslink, .tderrorlink, .tdsuccesschangeable, .tdnonobligated, .tdnonobligatedlink, .tdnonobligatedbyuser",function() {
			onTextField($(this).attr('id'));
		});
	} else {
		alert("Adminmodus deaktiviert");
		adminModeActive = false;
		$("input:not([type=hidden])").remove();
		$("body").off('click','td[id^="txt_"]');
		$("body").off('click');
		$(".tdsuccesschangeable").each(function() {
			$(this).removeClass();
			$(this).addClass("tdsuccess");
		});
		$("body").on('click',".tdsuccesslink, .tderrorlink, .tdnonobligated, .tdnonobligatedlink,.tdnonobligatedbyuser",function() {
			var cellID = $(this).attr('id');
			var isNoWeekday = cellID.substr(0,3) != "dow";

		
			if (isNoWeekday) {
				if ($(this).hasClass("tderrorlink") || $(this).hasClass("tdnonobligatedlink")) {
					openDialog(cellID,true);
				} else {
					openDialog(cellID,false);
				}
			}
		});
	}

}

function checkIfDateIsComplete(date) {
	
	var str = document.URL.split("plan");
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
}

function onTextField(tdID) {
	if (tdID.split("_")[0] == "dow") {
		//Wochentagsfelder sollen nicht editierbar sein
		return false;
	}
	
	var cellID = "textfield_" + $("#"+tdID).attr('id');
	var newTextField = $("<input type='text' id='"+cellID+"'></input>");
	$("#"+tdID).html(newTextField);
//	$("body").off('click',".tdsuccesslink, .tderrorlink");
	$("body").off('click');
	$("#"+cellID).focus();
	$("#"+cellID).on('keypress',function(event) {
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if (keycode == 13) {
			var str = cellID.split("_");
			var username = $("#"+cellID).val();
			var requestUrl = document.URL.split('plan')[0] + "plan/saveUserEntry/" + str[1] + "/" + str[2] + "/" + str[3] + "/" + username;
			$.ajax({
				type: 'POST',
				url: requestUrl,
				data: 'ajax=1',
				success: function(response) {
					if (response == "200") {
						var $td = (newTextField).parent();
						$(newTextField).remove();
						if ($td.attr('class').substr(0,14) == "tdnonobligated") {
								$td.removeClass();
							if (username == loggedInAs) {
								$td.addClass("tdnonobligatedbyuser");
							} else {
								$td.addClass("tdnonobligated");
							}
						} else {
							$td.removeClass();
							if (username == loggedInAs) {
								$td.addClass("tdsuccesslink");
							} else {
								$td.addClass("tdsuccesschangeable");
							}
						}
						$td.html(username);
						$("body").off('click');
						$("#"+cellID).off('keypress');
						$("body").on('click',".tdsuccesslink, .tderrorlink, .tdsuccesschangeable, .tdnonobligated, .tdnonobligatedlink, .tdnonobligatedbyuser",function() {
							onTextField($(this).attr('id'));
						});
					} else if (response == "210") {
						var $td = (newTextField).parent();
						$(newTextField).remove();
						if ($td.attr('class').substr(0,14) == "tdnonobligated") {
							$td.removeClass();
							$td.addClass("tdnonobligatedlink");
						} else {
							$td.removeClass();
							$td.addClass("tderrorlink");
						}
						$td.html("");
						$("body").off('click');
						$("#"+cellID).off('keypress');
						$("body").on('click',".tdsuccesslink, .tderrorlink, .tdsuccesschangeable, .tdnonobligated, .tdnonobligatedlink, .tdnonobligatedbyuser",function() {
							onTextField($(this).attr('id'));
						});
					} else {
						alert("Eror: Unknown ResponseCode [" + response +"]");						
					}
				},
				error: function() {
					alert("Ein unbekannter Fehler ist aufgetreten. Der AdminModus wurde deaktiviert!");
					activateAdminMode(false);
				},
				complete: function() {
					checkIfDateIsComplete(str[1]);
				}
			});
		}
	});
}
function ajaxHandler(cellID) {
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
			
		if (username != "") requestUrl += username;
		$.ajax( {
			type: 'POST',
			url: requestUrl,
			data: "ajax=1",
			success: function(response) {
				if (response == "200") {
					if ($("#"+cellID).hasClass("tdnonobligatedlink")) {
						 $("#"+cellID).removeClass();
						 $("#"+cellID).addClass("tdnonobligatedbyuser");
					} else {
					 $("#"+cellID).removeClass();
						$("#"+cellID).addClass("tdsuccesslink");
					}
					 $("#"+cellID).text(username);
				} else if (response == "210") {
					var newClass;
					if ($("#"+cellID).hasClass("tdnonobligatedbyuser")) {
						 newClass = "tdnonobligatedlink";
					} else {
						newClass = "tderrorlink"
					}
					$("#"+cellID).text("");
					$("#"+cellID).removeClass();
					$("#"+cellID).addClass(newClass);
				} else {
					alert ("Unknown response code: " + response);
				}
			},
			error: function(response) {
				alert ("Unbekannter Fehler");
			},
			complete: function() {
				checkIfDateIsComplete(date);
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
				var $th = $td.closest('table').find('th').eq($td.index()+2);
				$("#shiftAnchor").html($th.html());
						
				$("#cellID").val(cellID);
				$("#modalMenu").modal('show');
	}
}
