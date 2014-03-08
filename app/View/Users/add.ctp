<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username', array('label' => array('text' =>'Benutzername')));
		echo $this->Form->input('fname', array('label' => array('text' =>'Vorname')));
		echo $this->Form->input('lname', array('label' => array('text' =>'Nachname')));
		echo $this->Form->input('password', array('label' => array('text' =>'Passwort')));
		echo $this->Form->input('tel1', array('label' => array('text' =>'Telefonnummer 1')));
		echo $this->Form->input('tel2', array('label' => array('text' =>'Telefonnummer 2')));
		echo $this->Form->input('mail', array('label' => array('text' =>'E-Mail Adresse')));
	?>
	<table cellpadding = "0" cellspacing = "0" class = "table table-bordered">
	<colgroup>
	<col width = "20">
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
<?php echo $this->Form->end('Benutzer erstellen'); ?>
</div>
