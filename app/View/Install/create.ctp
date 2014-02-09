<div id="div_newdb">
	<?php
		echo $this->Form->create('User', array('url' => array('controller' => 'install', 'action' => 'create')));
		echo $this->Form->input('username', array('label' => 'Nachname'));
		echo $this->Form->input('fname', array('label' => 'Vorname'));
		echo $this->Form->input('password', array('label' => 'Passwort'));
		echo $this->Form->input('password2', array('label' => 'Passwort wiederholen', 'type' => 'password'));
		echo $this->Form->end('Installieren');
	?>
</div>