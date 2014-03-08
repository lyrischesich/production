<?php echo $this->element('actions',array(
		'actions' => array(
			'list' => array('text' => 'Spalten anzeigen','params' => array('controller' => 'columns','action' => 'index')),
			'add' => array('text' => 'Neue Spalte','params' => array('controller' => 'columns','action' => 'add')),
			'delete' => array('text' => 'Spalte löschen','htmlattributes' => array('onClick' => "if (confirm('Wollen Sie wirklich die Spalte \"".$this->Form->value('Column.name')."\" l\u00f6schen?')) window.location.href='../delete/".$this->Form->value('Column.id')."';event.returnValue = false; return false;"))
		)));
?>

<div class="columns form">
<?php echo $this->Form->create('Column'); ?>
	<fieldset>
		<legend><?php echo 'Spalte bearbeiten'; ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => 'Name'));
		echo $this->Form->input('type', array('label' => 'Typ', 'type' => 'select', 'options' => array(1 => 'Text', 2 => 'Benutzer')));
		echo $this->Form->input('obligated', array('label' => 'Belegung notwendig', 'type' => 'select', 'options' => array(0 => 'Nein', 1 => 'Ja')));
		echo $this->Form->input('req_admin', array('label' => 'Eintragen erfordert Adminrechte', 'type' => 'select', 'options' => array(0 => 'Nein', 1 => 'Ja')));

	?>
	</fieldset>
<?php echo $this->Form->end('Speichern'); ?>
</div>
</div>