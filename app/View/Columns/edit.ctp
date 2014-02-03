<div class="columns form">
<?php echo $this->Form->create('Column'); ?>
	<fieldset>
		<legend><?php echo __('Spalte bearbeiten'); ?></legend>
	<?php
		echo $this->Form->input('name', array('label' => 'Name', 'type' => 'text'));
		echo $this->Form->input('type', array('label' => 'Typ', 'type' => 'select', 'options' => array(1 => 'Text', 2 => 'Benutzer')));
		echo $this->Form->input('obligated', array('label' => 'Belegung notwendig', 'type' => 'select', 'options' => array(0 => 'Nein', 1 => 'Ja')));
		echo $this->Form->input('req_admin', array('label' => 'Eintragen erfordert Adminrechte', 'type' => 'select', 'options' => array(0 => 'Nein', 1 => 'Ja')));
		echo $this->Form->input('order', array('type' => 'hidden'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Speichern')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Aktionen'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $this->Form->value('Column.name')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Column.name'))); ?></li>
		<li><?php echo $this->Html->link(__('Spalten anzeigen'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Neue Spalte'), array('action' => 'add')); ?> </li>
	</ul>
</div>
