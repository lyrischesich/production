<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fname'); ?></dt>
		<dd>
			<?php echo h($user['User']['fname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lname'); ?></dt>
		<dd>
			<?php echo h($user['User']['lname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Passwd'); ?></dt>
		<dd>
			<?php echo h($user['User']['passwd']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tel1'); ?></dt>
		<dd>
			<?php echo h($user['User']['tel1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tel2'); ?></dt>
		<dd>
			<?php echo h($user['User']['tel2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mail'); ?></dt>
		<dd>
			<?php echo h($user['User']['mail']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Leave Date'); ?></dt>
		<dd>
			<?php echo h($user['User']['leave_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mo'); ?></dt>
		<dd>
			<?php echo h($user['User']['mo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Di'); ?></dt>
		<dd>
			<?php echo h($user['User']['di']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mi'); ?></dt>
		<dd>
			<?php echo h($user['User']['mi']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Do'); ?></dt>
		<dd>
			<?php echo h($user['User']['do']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fr'); ?></dt>
		<dd>
			<?php echo h($user['User']['fr']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Admin'); ?></dt>
		<dd>
			<?php echo h($user['User']['admin']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['username'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['username']), null, __('Are you sure you want to delete # %s?', $user['User']['username'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Columns'), array('controller' => 'columns', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Column'), array('controller' => 'columns', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Columns'); ?></h3>
	<?php if (!empty($user['Column'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Obligated'); ?></th>
		<th><?php echo __('Req Admin'); ?></th>
		<th><?php echo __('Order'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Column'] as $column): ?>
		<tr>
			<td><?php echo $column['name']; ?></td>
			<td><?php echo $column['type']; ?></td>
			<td><?php echo $column['obligated']; ?></td>
			<td><?php echo $column['req_admin']; ?></td>
			<td><?php echo $column['order']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'columns', 'action' => 'view', $column['name'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'columns', 'action' => 'edit', $column['name'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'columns', 'action' => 'delete', $column['name']), null, __('Are you sure you want to delete # %s?', $column['name'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Column'), array('controller' => 'columns', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
