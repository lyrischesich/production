<div class="columns index">
	<h2><?php echo __('Columns'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('obligated'); ?></th>
			<th><?php echo $this->Paginator->sort('req_admin'); ?></th>
			<th><?php echo $this->Paginator->sort('order'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($columns as $column): ?>
	<tr>
		<td><?php echo h($column['Column']['name']); ?>&nbsp;</td>
		<td><?php echo h($column['Column']['type']); ?>&nbsp;</td>
		<td><?php echo h($column['Column']['obligated']); ?>&nbsp;</td>
		<td><?php echo h($column['Column']['req_admin']); ?>&nbsp;</td>
		<td><?php echo h($column['Column']['order']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $column['Column']['name'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $column['Column']['name'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $column['Column']['name']), null, __('Are you sure you want to delete # %s?', $column['Column']['name'])); ?>
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
		<li><?php echo $this->Html->link(__('New Column'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
