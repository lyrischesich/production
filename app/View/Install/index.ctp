<h1>Installation</h1>

<p>
Bitte w&auml;hlen Sie die Installationsmethode:
</p>
<ul>
<li><a href="#" id="link_newdb">Ich m&ouml;chte eine neue, leere Datenbank anlegen</a></li>
<li><a href="#" id="link_olddb">Ich habe schon eine Datenbank und m&ouml;chte diese importieren</a></li>
</ul>
<script type="text/javascript">
$(document).ready(function() {

	$("#link_newdb").click( function() {
		$("#div_olddb").hide();
		$("#div_newdb").show();
	});

	$("#link_olddb").click( function () {
		$("#div_newdb").hide();
		$("#div_olddb").show();
	});
});
</script>

<div id="div_olddb" style="display: none;">
	<form action="/Cafeteria/install/import" method="POST">
		<div class="input text required" >
			<label for="uploadfield" >Bitte Datenbank ausw&auml;hlen</label>
			<input id="uploadfield" type="file" name="db" accept="application/sql" />
		</div>

		<input type="submit" value="Installieren">
	</form>
</div>
<?php require 'create.ctp'; ?>


<!-- 	<form action="/Cafeteria/install/create" method="POST"> -->
<!-- 		<div class="input text required"> -->
<!-- 			<label for="lastname">Nachname</label> -->
<!-- 			<input id="lastname" type="text" name="lastname"> -->
<!-- 		</div> -->
<!-- 		<div class="input text required"> -->
<!-- 			<label for="firstname">Vorname</label> -->
<!-- 			<input id="firstname" type="text" name="firstname"> -->
<!-- 		</div> -->
<!-- 		<div class="input password required"> -->
<!-- 			<label for="password">Passwort</label> -->
<!-- 			<input id="password" type="password" name="password"> -->
<!-- 		</div> -->
<!-- 		<div class="input password required"> -->
<!-- 			<label for="passwordRepeat">Passwort wiederholen</label> -->
<!-- 			<input id="passwordRepeat" type="password" name="passwordRepeat"> -->
<!-- 		</div> -->
<!-- 		<input type="submit" value="Installieren" /> -->
<!-- 	</form> -->