<div class="span2">
	<div class="well sidebar-nav">
		<ul class="nav nav-list">
		<li class="nav-header"> Aktionen </li>
		<li><?php echo $this->Html->link('New User', array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link('List Columns', array('controller' => 'columns', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link('New Column', array('controller' => 'columns', 'action' => 'add')); ?> </li>
		<?php echo $this->element('actions'); ?>
		</ul>
	</div>
</div>
<div class="span9">
	<h2><?php echo 'Benutzer'; ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('Benutzername'); ?></th>
			<th><?php echo $this->Paginator->sort('Vorname'); ?></th>
			<th><?php echo $this->Paginator->sort('Nachname'); ?></th>
			<th><?php echo $this->Paginator->sort('Telefonnummer 1'); ?></th>
			<th><?php echo $this->Paginator->sort('Telefonnummer 2'); ?></th>
			<th><?php echo $this->Paginator->sort('E-mail-Adresse'); ?></th>
			<th><?php echo $this->Paginator->sort('Ausstiegsdatum'); ?></th>
			<th><?php echo $this->Paginator->sort('Mo'); ?></th>
			<th><?php echo $this->Paginator->sort('Di'); ?></th>
			<th><?php echo $this->Paginator->sort('Mi'); ?></th>
			<th><?php echo $this->Paginator->sort('Do'); ?></th>
			<th><?php echo $this->Paginator->sort('Fr'); ?></th>
			<th><?php echo $this->Paginator->sort('Admin'); ?></th>
			<th class="actions"><?php echo 'Actions'; ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['fname']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['lname']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['tel1']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['tel2']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['mail']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['leave_date']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['mo']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['di']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['mi']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['do']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['fr']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['admin']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link('View', array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Form->postLink('Delete', array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['username'])); ?>
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
	<!-- <div class="p">  -->
	<?php
		//echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		//echo $this->Paginator->numbers(array('separator' => ''));
		//echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		echo $this->Paginator->pagination(array('div' => 'pagination'));
		
	?>
	<!--</div>   -->
</div>
