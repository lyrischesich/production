<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<legend><b>Benutzer editieren</b></legend>
		<?php echo $this->Form->input('id'); ?>
		<?php echo $this->Form->input('username', array('label' => array('text' =>'Benutzername')));?> 
		<?php echo $this->Form->input('fname', array('label' => array('text' =>'Vorname')));?> 
		<?php echo $this->Form->input('lname', array('label' => array('text' =>'Nachname')));?>
		<?php echo $this->Form->input('password', array('label' => array('text' =>'Passwort'), 'value'=>""));?> 
		<?php echo $this->Form->input('password2', array('label' => array('text' =>'Passwort wiederholen'), 'type' => 'password'));?> 
		<?php echo $this->Form->input('tel1', array('label' => array('text' =>'Telefonnummer 1')));?> 
		<?php echo $this->Form->input('tel2', array('label' => array('text' =>'Telefonnummer 2')));?> 
		<?php echo $this->Form->input('mail', array('label' => array('text' =>'E-Mail Adresse'))); ?> 
	

	<?php
		echo $this->Form->select('mo',$enumValues);
		echo $this->Form->select('di',$enumValues);
		echo $this->Form->select('mi',$enumValues);
		echo $this->Form->select('do',$enumValues);
		echo $this->Form->select('fr',$enumValues);
	?>
	<?php echo $this->element('legend'); ?>
<?php echo $this->Form->end('Änderungen speichern'); ?>
</div>
