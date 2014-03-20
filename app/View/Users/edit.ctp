<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo 'Benutzer editieren'; ?></legend>
	<form>
		<fieldset>
			<legend><b>Benutzerinformationen:</b><legend>
				<?php echo $this->Form->input('username', array('label' => array('text' =>'Benutzername')));?> 
				<?php echo $this->Form->input('fname', array('label' => array('text' =>'Vorname')));?> 
				<?php echo $this->Form->input('lname', array('label' => array('text' =>'Nachname')));?>
		</fieldset>
	</form>
	<fieldset>
	<td>		<?php echo $this->Form->input('password', array('label' => array('text' =>'Passwort'), 'value'=>""));?> </td>
	<td>		<?php echo $this->Form->input("password2", array('label' => array('text' =>'Passwort wiederholen')));?> </td>
	</fieldset>
	<fieldset>
		<td>	<?php echo $this->Form->input('tel1', array('label' => array('text' =>'Telefonnummer 1')));?> </td>
		<td>	<?php echo $this->Form->input('tel2', array('label' => array('text' =>'Telefonnummer 2')));?> </td>
		<td>	<?php echo $this->Form->input('mail', array('label' => array('text' =>'E-Mail Adresse'))); ?> </td>
	</fieldset>
	

	<?php
		echo $this->Form->select('mo',$enumValues);
		echo $this->Form->select('di',$enumValues);
		echo $this->Form->select('mi',$enumValues);
		echo $this->Form->select('do',$enumValues);
		echo $this->Form->select('fr',$enumValues);
	?>
	<?php echo $this->element('legend'); ?>
	</fieldset>
<?php echo $this->Form->end('Änderungen speichern'); ?>
</div>
