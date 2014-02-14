<?php echo $this->element('actions',array(
	'actions' => array(
// 		'new' => array('text' => 'Neue Spalte','params' => array('action' => 'add'))
	)));
?>

<div class="columns form">
<?php echo $this->Form->create('Column', array(
			'type' => 'post',
			'url' => array('controller' => 'columns', 'action' => 'add'),
			'inputDefaults' => array(
					'div' => 'control-group',
					'label' => array(
							'class' => 'control-label'
					 ),
			'class' => 'well form-horizontal')
			)); ?>
	<fieldset>
		<legend><?php echo 'Neue Spalte anlegen'; ?></legend>
	<?php
		echo $this->Form->input('name', array('label' => array('text' =>'Name'), 'div' => 'control-group', 'placeholder' => 'Bitte geben Sie den Namen der Spalte an') );
		echo $this->Form->input('select', array('label' => array('text' => 'Typ'), 'div' => 'control-group', 'options' => array(1 => 'Text', 2 => 'Benutzer')));
		echo $this->Form->input('obligated', array('label' => array('text' => 'Belegung notwendig'), 'type' => 'select', 'options' => array(0 => 'Nein', 1 => 'Ja')));
		echo $this->Form->input('req_admin', array('label' => array('text' => 'Eintragen erfordert Adminrechte'), 'type' => 'select', 'options' => array(0 => 'Nein', 1 => 'Ja')));
	?>
	</fieldset>
<?php echo $this->Form->end('Spalte anlegen'); ?>
</div>
<div class="actions">
	<h3><?php echo 'Aktionen'; ?></h3>
	<ul>
		<li><?php echo $this->Html->link('Spalten anzeigen', array('action' => 'index')); ?></li>
	</ul>
</div>

<!--  'type' => 'select', -->
