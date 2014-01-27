<div class="changelogs form">
<?php echo $this->Form->create('Changelog'); ?>
	<fieldset>
		<legend><?php echo __('Edit Changelog'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('for_date');
		echo $this->Form->input('change_date');
		echo $this->Form->input('name_before');
		echo $this->Form->input('name_after');
		echo $this->Form->input('shift');
		echo $this->Form->input('user_did');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Changelog.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Changelog.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Changelogs'), array('action' => 'index')); ?></li>
	</ul>
</div>
