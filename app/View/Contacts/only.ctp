<h2>Telefonliste für <?php echo $dow; ?></h2>
	<br />
	<table border='1' align='center'>
  		<tr>
		    <td class='tdsuccess'>G</td>
	    	<td>Ganze Schicht, auch Hälfte</td>
  		</tr>
	  	<tr>
    		<td class='tdwarning'>H</td>
	    	<td>Halbe Schicht</td>
	  	</tr>
	  	<tr>
	  		<td class='tdwarning'>1</td>
	  		<td>Nur 1. Hälfte</td>
	  	</tr>
	  	<tr>
	  		<td class='tdwarning'>2</td>
	  		<td>Nur 2. Hälfte</td>
	  	</tr>
	</table>
	<br />

	<table cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="contactlist">
		<tr>
			<th>Schicht</th>
			<th><?php echo $this->Paginator->sort('lname','Nachname'); ?></th>
			<th><?php echo $this->Paginator->sort('fname','Vorname'); ?></th>
			<th><?php echo $this->Paginator->sort('tel1','Tel1'); ?></th>
			<th><?php echo $this->Paginator->sort('tel2','Tel2'); ?></th>
			<th><?php echo $this->Paginator->sort('mail','E-Mail'); ?></th>
		</tr>
		<?php foreach($users as $user): ?>
		<?php $state = ($user['User']['leave_date'] == null) ? "activeUser" : "inactiveUser"; ?>
		<tr class="<?php echo $state?>">
			<td class="<?php echo $user['User']['shift']['class']; ?>">
				<?php echo h($user['User']['shift']['value']); ?>
			</td>
			<td><?php echo h($user['User']['lname']); ?> &nbsp; </td>
			<td><?php echo h($user['User']['fname']); ?> &nbsp; </td>
			<td><?php echo h($user['User']['tel1']);  ?> &nbsp; </td>
			<td><?php echo h($user['User']['tel2']);  ?> &nbsp; </td>
			<td><i class="icon-envelope"></i>
				<?php echo $this->Html->link(h($user['User']['mail']),array(
						'controller' => 'contacts',
						'action' => 'mail',
						$user['User']['mail']
						)); ?>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
