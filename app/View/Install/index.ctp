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

<div id="div_newdb" style="display: none;">
	<?php
		echo $this->Form->create('User', array('url' => array('controller' => 'install', 'action' => 'create')));
		echo $this->Form->input('username', array('label' => 'Nachname'));
		echo $this->Form->input('fname', array('label' => 'Vorname'));
		echo $this->Form->input('password', array('label' => 'Passwort'));
		echo $this->Form->input('password2', array('label' => 'Passwort wiederholen', 'type' => 'password'));
		echo $this->Form->end('Installieren');
	?>
</div>



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