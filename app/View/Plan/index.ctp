<?php echo $this->element('actions',array(
			'actions' => array(
				'print' => array('text' => 'Druckversion anzeigen', 'params' => array('controller' => 'Plan','action' => 'createPDF')),
				'admin' => array('text' => 'Adminmodus', 'params' => array('id' => 'activateAdminMode')),
				'legende' => array('text' => 'Hilfe anzeigen', 'params' => array('id' => 'help', 'onClick' => 'showHelp();'))
		)));
?>
<h2>Cafeteriaplan</h2>
<br />	
<table class="table table-condensed table-bordered table-centered" id="planTable">
	<th>Tag</th>
	<th>Datum</th>
	<!-- Header -->
	<?php foreach ($columns as $column):?>
		<?php if ($column['Column']['type'] == 2):?>
			<th colspan="2"><?php echo $column['Column']['name']; ?></th>
		<?php else:?>	
			<th><?php echo $column['Column']['name']; ?></th>
		<?php endif;?>
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
?>

			<td class="<?php echo $class;?>"><?php echo $result['dow']?></td>
			<td><?php echo date("d.m.Y",strtotime($key)); ?> </td> 	
<?php 
		//Spalten nacheinander ausgeben
		foreach ($columns as $column) {
			//Ist die Spalte eine Textspalte?
			if ($column['Column']['type'] == 1) {
				//Wenn ja, dann gebe "einfach" die Bemerkung aus
				
				if (isset($result[$column['Column']['id']])) {
					echo "<td>".$result[$column['Column']['id']]."</td>";
				} else {
					echo "<td></td>";
				}
								
			} else if ($column['Column']['type'] == 2) {
				//Ist die Spalte keine Textspalte, dann füge die Dienste entsprechend ein.
				
				if (isset($result[$column['Column']['id']]['1']) && isset($result[$column['Column']['id']]['2'])) {
					//Beide Dienste an dem Tag sind bereit belegt. Bleibt die Frage: Von einer oder von 2 Personen?
					if ($result[$column['Column']['id']]['1']['userid'] == $result[$column['Column']['id']]['2']['userid']) {
						//Die gleiche Person übernimmt den Dienst
						echo "<td colspan='2' id='".$key."_".$column['Column']['id']."' class='success'>".$result[$column['Column']['id']]['1']['username']."</td>";
					} else {
						//Zwei verschiedene Halbschichten
						echo "<td id='".$key."_".$column['Column']['id']."_1' class='success'>".$result[$column['Column']['id']]['1']['username']."</td>";
						echo "<td id='".$key."_".$column['Column']['id']."_2' class='success'>".$result[$column['Column']['id']]['2']['username']."</td>";
					}
				} else if (isset($result[$column['Column']['id']]['1']) && !isset($result[$column['Column']['id']]['2'])) {
					//Jetzt ist nur der erste Dienst belegt
						echo "<td id='".$key."_".$column['Column']['id']."_1' class='success'>".$result[$column['Column']['id']]['1']['username']."</td>";
						echo "<td id='".$key."_".$column['Column']['id']."_2' class='error'></td>";						
				} else if (!isset($result[$column['Column']['id']]['1']) && isset($result[$column['Column']['id']]['2'])) {
					//Nur der zweite Dienst ist belegt
					echo "<td id='".$key."_".$column['Column']['id']."_1' class='error'></td>";
					echo "<td id='".$key."_".$column['Column']['id']."_2' class='success'>".$result[$column['Column']['id']]['2']['username']."</td>";
				} else if (!isset($result[$column['Column']['id']]['1']) && !isset($result[$column['Column']['id']]['2'])) {
					//Noch gar kein Dienst wurde belegt
					
					//Das Datum ist entweder ein SpecialDate oder Wochenende und es müssen Rauten ausgegeben werden
					if ($type == "inactive" && !$result['weekend']) {
						echo "<td colspan='2' class='success'>#</td>";
					} elseif ($result['weekend']) {
						echo "<td colspan='2'></td>";
					} else {
					//Oder es hat sich einfach noch niemand Eingetragen
						echo "<td colspan='2' id='".$key."_".$column['Column']['id']."' class='error'></td>";
					}
				}
							
						
			}
		}
?>
		</tr>
	<?php endforeach; ?>
</table>
</div>
