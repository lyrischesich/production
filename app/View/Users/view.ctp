<div class="users view">
<h2><?php echo 'Benutzer'; ?></h2>
	<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo 'Benutzer editieren'; ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('fname');
		echo $this->Form->input('lname');
		echo $this->Form->input('password');
		echo $this->Form->input('password2')
		echo $this->Form->input('tel1');
		echo $this->Form->input('tel2');
		echo $this->Form->input('mail');
	?>
	<table cellpadding = "0" cellspacing = "0" class = "table table-bordered">
	<colgroup>
	<col width = "20" length = "20">
	<col>
	</colgroup>
	<tr>
		<td><?php echo "G"; ?></td>
		<td><?php echo "Ganze Schicht"; ?></td>
	</tr>
	<tr>
		<td><?php echo "H"; ?></td>
		<td><?php echo "Halbe Schicht"; ?></td>
	</tr>
	<tr>
		<td><?php echo "1"; ?></td>
		<td><?php echo "Nur 1. Hälfte"; ?></td>
	</tr>
	<tr>
		<td><?php echo "2"; ?></td>
		<td><?php echo "Nur 2. Hälfte"; ?></td>
	</tr>
	<tr>
		<td><?php echo "N"; ?></td>
		<td><?php echo "Kein Dienst"; ?></td>
	</tr>
	</table>

	<?php
		echo $this->Form->select('mo',$enumValues);
		echo $this->Form->select('di',$enumValues);
		echo $this->Form->select('mi',$enumValues);
		echo $this->Form->select('do',$enumValues);
		echo $this->Form->select('fr',$enumValues);
		echo $this->Form->input('admin');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
