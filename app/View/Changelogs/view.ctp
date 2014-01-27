<div class="changelogs view">
<h2><?php echo __('Changelog'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($changelog['Changelog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('For Date'); ?></dt>
		<dd>
			<?php echo h($changelog['Changelog']['for_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Change Date'); ?></dt>
		<dd>
			<?php echo h($changelog['Changelog']['change_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Before'); ?></dt>
		<dd>
			<?php echo h($changelog['Changelog']['name_before']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name After'); ?></dt>
		<dd>
			<?php echo h($changelog['Changelog']['name_after']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Shift'); ?></dt>
		<dd>
			<?php echo h($changelog['Changelog']['shift']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Did'); ?></dt>
		<dd>
			<?php echo h($changelog['Changelog']['user_did']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Changelog'), array('action' => 'edit', $changelog['Changelog']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Changelog'), array('action' => 'delete', $changelog['Changelog']['id']), null, __('Are you sure you want to delete # %s?', $changelog['Changelog']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Changelogs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Changelog'), array('action' => 'add')); ?> </li>
	</ul>
</div>
