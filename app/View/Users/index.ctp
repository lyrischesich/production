<?php echo $this->element('actions', array( 'actions' => array(
	'New User' => array('text' => 'Neuen Benutzer einfügen', 'params' => array('controller' => 'Users', 'action' => 'add'))))); ?>
</div>
<div class="span9">
	<h2><?php echo 'Benutzer'; ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('username', 'Benutzername'); ?></th>
			<th><?php echo $this->Paginator->sort('fname', 'Vorname'); ?></th>
			<th><?php echo $this->Paginator->sort('lname', 'Nachname'); ?></th>
			<th><?php echo $this->Paginator->sort('tel1', 'Telefonnummer 1'); ?></th>
			<th><?php echo $this->Paginator->sort('tel2', 'Telefonnummer 2'); ?></th>
			<th><?php echo $this->Paginator->sort('mail', 'E-Mail Adresse'); ?></th>
			<th><?php echo $this->Paginator->sort('leave_date', 'Ausstiegsdatum'); ?></th>
			<th><?php echo $this->Paginator->sort('mo'); ?></th>
			<th><?php echo $this->Paginator->sort('di'); ?></th>
			<th><?php echo $this->Paginator->sort('mi'); ?></th>
			<th><?php echo $this->Paginator->sort('do'); ?></th>
			<th><?php echo $this->Paginator->sort('fr'); ?></th>
			<th><?php echo $this->Paginator->sort('admin', 'Administrator'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
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
	'format' => __('Seite {:page} aus {:pages}, zeigt {:current} Einträge von insgesamt {:count}, Anfang bei Eintrag #{:start}, Ende bei Eintrag #{:end}')
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
