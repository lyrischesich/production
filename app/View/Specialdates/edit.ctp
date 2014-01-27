<div class="specialdates form">
<?php echo $this->Form->create('Specialdate'); ?>
	<fieldset>
		<legend><?php echo __('Edit Specialdate'); ?></legend>
	<?php
		echo $this->Form->input('date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Specialdate.date')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Specialdate.date'))); ?></li>
		<li><?php echo $this->Html->link(__('List Specialdates'), array('action' => 'index')); ?></li>
	</ul>
</div>
