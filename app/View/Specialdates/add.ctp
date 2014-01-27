<div class="specialdates form">
<?php echo $this->Form->create('Specialdate'); ?>
	<fieldset>
		<legend><?php echo __('Add Specialdate'); ?></legend>
	<?php
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Specialdates'), array('action' => 'index')); ?></li>
	</ul>
</div>
