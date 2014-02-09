<script type="text/javascript">
	function check(input) {
		if (input.value != document.getElementById('password').value) {
			input.setCustomValidity(unescape("Die Passw%F6rter m%FCssen %FCbereinstimmen."));
		} else {
			input.setCustomValidity('');
		}
	}
</script>
<div id="div_newdb">
	<?php
		echo $this->Form->create('User', array('url' => array('controller' => 'install', 'action' => 'create')));
		echo $this->Form->input('username', array('label' => 'Nachname'));
		echo $this->Form->input('fname', array('label' => 'Vorname'));
		echo $this->Form->input('password', array('label' => 'Passwort'));
		echo $this->Form->input('password2', array('label' => 'Passwort wiederholen', 'type' => 'password', 'oninput' => 'check(this)'));
		echo $this->Form->end('Installieren');
	?>
</div>