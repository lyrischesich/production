<?php echo $this->element('actions', array( 'actions' => array(
	'New User' => array('text' => 'Neuen Benutzer einfügen', 'params' => array('controller' => 'Users', 'action' => 'add')),
	'save changes' => array('text' => 'Änderungen speichern', 'htmlattributes' => array('onClick' =>"document.forms['UserIndexForm'].submit();")),
	'reset changes' => array('text' => 'Änderungen zurücksetzen', 'params' => array('controller' => 'Users', 'action' => 'index'))
))); ?>
</div>
<div class="span9">
	<?php echo $this->Form->create('User'); ?>
	<h2><?php echo 'Benutzerverwaltung'; ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('username', 'Name'); ?></th>
			<th><?php echo $this->Paginator->sort('leave_date', 'Aktiv'); ?></th>
			<th><?php echo $this->Paginator->sort('admin', 'Administrator'); ?></th>
			<th class="actions"><?php echo 'Aktionen'; ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['username']." (".$user['User']['fname']." ".$user['User']['lname'].")"); ?>&nbsp;</td>
		<td><?php echo $this->Form->input('leave_date', array('type' => 'checkbox', 'label' => array('text' =>  ($user['User']['leave_date'] == null) ? "(noch aktiv)" : "inaktiv seit dem ".date('d. m. Y', strtotime($user['User']['leave_date'])))  , 'checked' => $user['User']['leave_date'] == null, 'name' => "data[User][".$user['User']['id']."][leave_date]", 'id' => "Userleave_date".$user['User']['id'])); ?> </td>
		<td><?php echo $this->Form->input('admin', array('type' => 'checkbox', 'label' => array('text' =>  ($user['User']['admin']) ? "ist Admin" : "ist kein Admin"), 'name' => "data[User][".$user['User']['id']."][admin]", 'checked' => $user['User']['admin'], 'id' => "UserAdmin".$user['User']['id']."", 'align' => 'right')); ?></td>

		<td class="actions">
			<?php echo $this->Html->link('Anzeigen |', array('action' => 'view', $user['User']['id'])); ?>
			<?php echo $this->Html->link(' Editieren |', array('action' => 'edit', $user['User']['id'])); ?>
			<?php echo $this->Form->postLink(' Löschen', array('action' => 'delete', $user['User']['id']), null, __('Wollen Sie wirklich den Benutzer "%s" löschen?', $user['User']['username'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
	<?php 
// 	echo $this->Form->input('Änderungen zurücksetzen', array('type' => 'button', 'onClick' => "window.location.href='.'", 'label' => false));
	echo $this->Form->end('Änderungen speichern'); 
	?>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Seite {:page} von {:pages}, zeigt {:current} Einträge von insgesamt {:count}, Anfang bei Eintrag {:start}, Ende bei Eintrag {:end}')
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
