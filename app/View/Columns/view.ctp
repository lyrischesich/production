<div class="columns view">
<h2><?php echo __('Column'); ?></h2>
	<dl>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($column['Column']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($column['Column']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Obligated'); ?></dt>
		<dd>
			<?php echo h($column['Column']['obligated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Req Admin'); ?></dt>
		<dd>
			<?php echo h($column['Column']['req_admin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Order'); ?></dt>
		<dd>
			<?php echo h($column['Column']['order']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Column'), array('action' => 'edit', $column['Column']['name'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Column'), array('action' => 'delete', $column['Column']['name']), null, __('Are you sure you want to delete # %s?', $column['Column']['name'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Columns'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Column'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Users'); ?></h3>
	<?php if (!empty($column['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Fname'); ?></th>
		<th><?php echo __('Lname'); ?></th>
		<th><?php echo __('Passwd'); ?></th>
		<th><?php echo __('Tel1'); ?></th>
		<th><?php echo __('Tel2'); ?></th>
		<th><?php echo __('Mail'); ?></th>
		<th><?php echo __('Leave Date'); ?></th>
		<th><?php echo __('Mo'); ?></th>
		<th><?php echo __('Di'); ?></th>
		<th><?php echo __('Mi'); ?></th>
		<th><?php echo __('Do'); ?></th>
		<th><?php echo __('Fr'); ?></th>
		<th><?php echo __('Admin'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($column['User'] as $user): ?>
		<tr>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['fname']; ?></td>
			<td><?php echo $user['lname']; ?></td>
			<td><?php echo $user['passwd']; ?></td>
			<td><?php echo $user['tel1']; ?></td>
			<td><?php echo $user['tel2']; ?></td>
			<td><?php echo $user['mail']; ?></td>
			<td><?php echo $user['leave_date']; ?></td>
			<td><?php echo $user['mo']; ?></td>
			<td><?php echo $user['di']; ?></td>
			<td><?php echo $user['mi']; ?></td>
			<td><?php echo $user['do']; ?></td>
			<td><?php echo $user['fr']; ?></td>
			<td><?php echo $user['admin']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['username'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['username'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['username']), null, __('Are you sure you want to delete # %s?', $user['username'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
