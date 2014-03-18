<?php
echo $this->element('actions', array('actions' => array())); 
?>

<h2>Automatische Prozesse</h2>
<table class='table table-bordered table-striped'>
	<tr>
		<th>Aktion</th>
		<th>letzte Ausführung</th>
		<th>Ergebnis</th>
		<th>Manuelle Ausführung</th>
	</tr>
  <?php
  	foreach ($performedActions as $performedAction) {
		echo "<tr>";
		echo "<td>".$performedAction['actionname']."</td>";
		echo "<td>".date('d.m.Y H:i:s', $performedAction['lastExecution'])."</td>";
		echo "<td>".($performedAction['success'] == "true" ? "erfolgreich" : "fehlgeschlagen")."</td>";
		echo "<td>".$this->Html->link('jetzt starten', array('controller' => 'auto', 'action' => 'index', $performedAction['controller'], $performedAction['action']))."</td>";
		echo "</tr>";
	}
  
  ?>
</table>
</div>