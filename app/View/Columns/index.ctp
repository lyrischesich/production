<div class="columns index">
	<h2><?php echo __('Spalten'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name', 'Name'); ?></th>
			<th><?php echo $this->Paginator->sort('type', 'Typ'); ?></th>
			<th><?php echo $this->Paginator->sort('obligated', 'Belegung notwendig'); ?></th>
			<th><?php echo $this->Paginator->sort('req_admin', 'Eintragen erfordert Adminrechte'); ?></th>
			<th><?php echo $this->Paginator->sort('order', 'Position im Plan'); ?></th>
			<th class="actions"><?php echo __('Aktionen'); ?></th>
	</tr>
	
	<?php 
	$yesno = array(0 => 'Nein', 1 => 'Ja');
	$types = array(1 => 'Text', 2 => 'Benutzer') 
	?>
	<?php foreach ($columns as $column): ?>
	<tr>
		<td><?php echo h($column['Column']['name']); ?>&nbsp;</td>
		<td><?php echo h($types[$column['Column']['type']]); ?>&nbsp;</td>
		<td><?php echo h($yesno[$column['Column']['obligated']]); ?>&nbsp;</td>
		<td><?php echo h($yesno[$column['Column']['req_admin']]); ?>&nbsp;</td>
		<td><?php echo h($column['Column']['order']); ?>&nbsp;</td> 

		<td class="actions">
			<?php echo $this->Html->link(__('Bearbeiten'), array('action' => 'edit', $column['Column']['name'])); ?>
			<?php echo $this->Form->postLink(__('Löschen'), array('action' => 'delete', $column['Column']['name']), null, __('Are you sure you want to delete # %s?', $column['Column']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Seite {:page} von {:pages}, zeige {:current} Einträge von {:count} insgesamt, von Eintrag {:start} bis Eintrag {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('Zurück'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('Weiter') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Aktionen'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Neue Spalte'), array('action' => 'add')); ?></li>
	</ul>
</div>
