<?php echo $this->element('actions',array('actions' => $actions)); ?>
<h2>Kontoverwaltung</h2>
	<?php echo $this->Form->create('User',array(
		'type' => 'post',
		'url' => array('controller' => 'users','action' => 'edit'),
		'inputDefaults' => array(
			'div' => 'control-group',
			'label' => array(
				'class' => 'control-label'				
				),
			),
		'class' => 'well'
		)); ?>
		<?php echo $this->Form->input('id'); ?>
		<?php echo $this->Form->input('username',array(
				'placeholder' => 'Benutzernamen eingeben',
				'div' => 'control-group',
				'label' => array(
						'text' => 'Benutzername:'
			)));?> 
		<?php echo $this->Form->input('fname', array(
				'placeholder' => 'Vornamen eingeben',
				'div' => 'control-group',
				'label' => array(
						'text' => 'Vorname:'
			)));?> 
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
	<?php echo $this->Form->submit('Änderungen speichern', array(
			'div' => false,
			'class' => 'btn btn-primary'
		)); ?>
<?php echo $this->Form->end(); ?>
</div>
