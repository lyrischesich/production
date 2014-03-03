<?php echo $this->element('actions',array(
			'actions' => array(
				'print' => array('text' => 'Druckversion anzeigen', 'params' => array('controller' => 'Plan','action' => 'createPDF')),
				'admin' => array('text' => 'Adminmodus', 'params' => array('id' => 'activateAdminMode')),
				'legende' => array('text' => 'Hilfe anzeigen', 'params' => array('id' => 'help', 'onClick' => 'showHelp();'))
		)));
?>
<h2>Cafeteriaplan &#2665;</h2>
<br />	
<table class="table table-condensed" id="planTable">
	<th>Tag</th>
	<th>Datum</th>
	<!-- Header -->
	<?php foreach ($columns as $column):?>
		<th><?php echo $column['Column']['name']; ?></th>	
	<?php endforeach;?>

	<!-- Data -->
	<?php foreach ($results as $key => $result): 
		//Initialisiere die Variable, welche das Aussehen der Tabellenzeile regelt:
		$class = "";

		if (array_key_exists("specialdate",$result)) {
			//Lege fest, ob das Datum ein Specialdate ist und speichere das Ergebnis in $type
			if ($result['weekend']) { $type = "active"; } else { $type = "inactive";  $class="success";}
		} else {
			if ($result['weekend']) { $type="inactive"; } else { $type = "active"; }
		}

			echo "<tr id='".$key."' class='".$type."Day'>";
		
		//Komplette, aktive Tage grün, die nicht kompletten, aktiven Rot 
		if ($result['complete'] && $type=="active") {
			$class = "success";
		} else if(!$result['complete'] && $type=="active") {
			$class = "error";
	 	}	

		//Setze die Variable für die Bemerkung
	?>

			<td class="<?php echo $class;?>"><?php echo $result['dow']?></td>
			<td><?php echo date("d.m.Y",strtotime($key)); ?> </td> 	

		</tr>
	<?php endforeach; ?>
</table>
</div>
