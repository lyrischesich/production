<?php echo $this->element('actions', array (
	'actions' => array(
		'less' => array('text' => 'Weniger anzeigen','params' => array('controller'  => 'changelogs', 'action' => 'index', count($changelogs) - 50)),
		'more' => array('text' => 'Mehr anzeigen','params' => array('controller'  => 'changelogs', 'action' => 'index', count($changelogs) + 50))
))); ?>


<div class="changelogs index">
	<h2><?php echo __('Changelogs'); ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('for_date', 'vorgesehenes Datum'); ?></th>
			<th><?php echo $this->Paginator->sort('change_date', 'Änderungsdatum'); ?></th>
			<th><?php echo $this->Paginator->sort('value_before', 'vorheriger Eintrag'); ?></th>
			<th><?php echo $this->Paginator->sort('value_after', 'neuer Eintrag'); ?></th>
			<th><?php echo $this->Paginator->sort('column_name', 'betroffene Schicht'); ?></th>
			<th><?php echo $this->Paginator->sort('user_did', 'ändernder Nutzer'); ?></th>
	</tr>
	<?php foreach ($changelogs as $changelog): ?>
	<tr>
		<td><?php echo h($changelog['Changelog']['for_date']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['change_date']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['value_before']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['value_after']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['column_name']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['user_did']); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => 'Seite {:page} aus {:pages}, zeigt {:current} Einträge aus insgesamt {:count}, Anfang bei Eintrag {:start}, Ende bei Eintrag {:end}')
	);
	?>	</p>
	<div class="paging">
	<?php
		//echo $this->Paginator->prev('< ' . 'vorherige Seite', array(), null, array('class' => 'prev disabled'));
		//echo $this->Paginator->numbers(array('separator' => ''));
		//echo $this->Paginator->next('nächste Seite' . ' >', array(), null, array('class' => 'next disabled'));
		echo $this->Paginator->pagination(array('div' => 'pagination'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php// echo $this->Html->link(__('New Changelog'), array('action' => 'add')); ?></li>
	</ul>
</div>	

</div>
