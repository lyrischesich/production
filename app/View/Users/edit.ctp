<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('fname');
		echo $this->Form->input('lname');
		echo $this->Form->input('passwd');
		echo $this->Form->input('tel1');
		echo $this->Form->input('tel2');
		echo $this->Form->input('mail');
		echo $this->Form->input('leave_date');
		echo $this->Form->input('mo');
		echo $this->Form->input('di');
		echo $this->Form->input('mi');
		echo $this->Form->input('do');
		echo $this->Form->input('fr');
		echo $this->Form->input('admin');
		echo $this->Form->input('Column');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.username')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.username'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Columns'), array('controller' => 'columns', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Column'), array('controller' => 'columns', 'action' => 'add')); ?> </li>
	</ul>
</div>
