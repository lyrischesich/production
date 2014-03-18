<?php


debug($performedActions);

?>

<h2>Automatische Prozesse</h2>
<table class='table table-bordered table-striped'>
	<tr>
		<th>Aktion</th>
		<th>letzte Ausführung</th>
		<th></th>
	</tr>
  <?php 
  	foreach ($performedActions as $performedAction) {
		echo "<tr>";
		echo "<td>".$performedAction['actionname']."</td>";
		echo "</tr>";
	}
  
  ?>
</table>

