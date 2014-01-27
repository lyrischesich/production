<div class="specialdates view">
<h2><?php echo __('Specialdate'); ?></h2>
	<dl>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($specialdate['Specialdate']['date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Specialdate'), array('action' => 'edit', $specialdate['Specialdate']['date'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Specialdate'), array('action' => 'delete', $specialdate['Specialdate']['date']), null, __('Are you sure you want to delete # %s?', $specialdate['Specialdate']['date'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Specialdates'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Specialdate'), array('action' => 'add')); ?> </li>
	</ul>
</div>
