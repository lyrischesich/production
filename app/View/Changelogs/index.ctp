<div class="changelogs index">
	<h2><?php echo __('Changelogs'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('for_date'); ?></th>
			<th><?php echo $this->Paginator->sort('change_date'); ?></th>
			<th><?php echo $this->Paginator->sort('name_before'); ?></th>
			<th><?php echo $this->Paginator->sort('name_after'); ?></th>
			<th><?php echo $this->Paginator->sort('shift'); ?></th>
			<th><?php echo $this->Paginator->sort('user_did'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($changelogs as $changelog): ?>
	<tr>
		<td><?php echo h($changelog['Changelog']['id']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['for_date']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['change_date']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['value_before']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['value_after']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['column_name']); ?>&nbsp;</td>
		<td><?php echo h($changelog['Changelog']['user_did']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $changelog['Changelog']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $changelog['Changelog']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $changelog['Changelog']['id']), null, __('Are you sure you want to delete # %s?', $changelog['Changelog']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Changelog'), array('action' => 'add')); ?></li>
	</ul>
</div>
