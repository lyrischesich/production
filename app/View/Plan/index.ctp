<?php echo $this->element('actions',array(
			'actions' => array(
				'print' => array('text' => 'Druckversion anzeigen', 'params' => array('controller' => 'Plan','action' => 'createPDF')),
				'admin' => array('text' => 'Adminmodus', 'params' => array('id' => 'activateAdminMode')),
				'legende' => array('text' => 'Hilfe anzeigen', 'params' => array('id' => 'help', 'onClick' => 'showHelp();'))
		)));
?>
<h2>Heute geschlossen</h2>
<br />	
<table class="table table-condensed" id="planTable">
	<th>Tag</th>
	<th>Datum</th>
	<!-- Header -->
	<?php foreach ($columns as $column):?>
		<th><?php echo $column['Column']['name']; ?></th>	
	<?php endforeach;?>

	<!-- Data -->
	<?php foreach ($results as $result): ?>
		
	<?php endforeach; ?>
</table>
<?php debug($results); ?>

</div>
