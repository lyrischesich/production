<?php echo $this->Html->script('planScript.js'); ?>

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
	<?php 
	$success = "class='tdsuccess'";
	$error = "class='tderror'";
	$errorlink = "class='tderrorlink'";
	
	foreach ($results as $key => $result): 
		//Initialisiere die Variable, welche das Aussehen der Tabellenzeile regelt:
		$class = "";

		if (array_key_exists("specialdate",$result)) {
			//Lege fest, ob das Datum ein Specialdate ist und speichere das Ergebnis in $type
			if ($result['weekend']) { $type = "active"; } else { $type = "inactive";  $class=$success;}
		} else {
			if ($result['weekend']) { $type="inactive"; } else { $type = "active"; }
		}

			echo "<tr id='".$key."' class='".$type."Day'>";
		
		$dateIsInFuture = strtotime($key) >= time();
		//Komplette, aktive Tage grün, die nicht kompletten, aktiven Rot 
		if ($result['complete'] && $type=="active") {
			$class = $success;
			$onclick = "";
		} else if(!$result['complete'] && $type=="active" && !$dateIsInFuture) {
			$class = $error;
			$onclick = "";
	 	} else if (!$result['complete'] && $type=="active" && $dateIsInFuture) {
			$class = $errorlink;
			$onclick = "onClick=\"window.open('contacts/only/$key',  'toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=800,height=550,left=10,top=10')\"";
		} else {
			//Alles andere
			$onclick = "";
		}
?>

			<td <?php echo $class." "; echo $onclick; ?>>
			<?php echo $result['dow']; ?>
			</td>
			<td><?php echo date("d.m.Y",strtotime($key)); ?> </td> 	
<?php 
		//Spalten nacheinander ausgeben
		foreach ($columns as $column) {
			$classString = "";
			
			//Ist die Spalte eine Textspalte?
			if ($column['Column']['type'] == 1) {
				//Wenn ja, dann gebe "einfach" die Bemerkung aus
				if (isset($result[$column['Column']['id']])) {
					if ($column['Column']['obligated']) $classString = $success;
					echo "<td id='txt_".$key."' $classString>".$result[$column['Column']['id']]."</td>";
				} else {
					if ($column['Column']['obligated'] && $type == "active") $classString = ($dateIsInFuture) ? $errorlink : $error;
					echo "<td id='txt_".$key."' $classString></td>";
				}
								
			} else if ($column['Column']['type'] == 2) {
				//Ist die Spalte keine Textspalte, dann füge die Dienste entsprechend ein.
				
// 				//Ist das Datum ist entweder ein Specialdate oder Wochenende und es müssen Rauten ausgegeben werden
// 				if ($type == "inactive" && !$result['weekend']) {
// 					if ($column['Column']['obligated']) {
// 						$classString = $success;
// 						echo "<td colspan='2' $classString>#</td>";
// 					} else {
// 						echo "<td colspan='2'></td>";
// 					}
// 					continue;
// 				} else if ($type == "inactive" && $result['weekend']) {
// 					echo "<td colspan='2'></td>";
// 				} 
				
				if ($type == "inactive") {
					if (!$result['weekend']) {
						if ($column['Column']['obligated']) {
							$classString = $success;
							echo "<td colspan='2' $classString>#</td>";
						} else {
							echo "<td colspan='2'></td>";
						}
					} else {
						echo "<td colspan='2'></td>";
					}
				} else 	if (isset($result[$column['Column']['id']]['1']) && isset($result[$column['Column']['id']]['2'])) {
					if ($column['Column']['obligated']) $classString = $success;
				
					//Beide Dienste an dem Tag sind bereit belegt. Bleibt die Frage: Von einer oder von 2 Personen?	
					if ($result[$column['Column']['id']]['1']['userid'] == $result[$column['Column']['id']]['2']['userid']) {
						//Die gleiche Person übernimmt den Dienst	
						echo "<td colspan='2' id='".$key."_".$column['Column']['id']."' $classString'>".$result[$column['Column']['id']]['1']['username']."</td>";
					} else {
						//Zwei verschiedene Halbschichten
						echo "<td id='".$key."_".$column['Column']['id']."_1' $classString>".$result[$column['Column']['id']]['1']['username']."</td>";
						echo "<td id='".$key."_".$column['Column']['id']."_2' $classString>".$result[$column['Column']['id']]['2']['username']."</td>";
					}
				} else if (isset($result[$column['Column']['id']]['1']) && !isset($result[$column['Column']['id']]['2'])) {
					//Jetzt ist nur der erste Dienst belegt
						if ($column['Column']['obligated']) $classString = $success;
						echo "<td id='".$key."_".$column['Column']['id']."_1' $classString>".$result[$column['Column']['id']]['1']['username']."</td>";
						if ($column['Column']['obligated']) $classString = ($dateIsInFuture) ? $errorlink : $error;
						echo "<td id='".$key."_".$column['Column']['id']."_2' $classString></td>";						
				} else if (!isset($result[$column['Column']['id']]['1']) && isset($result[$column['Column']['id']]['2'])) {
					//Nur der zweite Dienst ist belegt
					if ($column['Column']['obligated']) $classString = ($dateIsInFuture) ? $errorlink : $error;
					echo "<td id='".$key."_".$column['Column']['id']."_1' $classString></td>";
					if ($column['Column']['obligated']) $classString = $success;
					echo "<td id='".$key."_".$column['Column']['id']."_2' $classString>".$result[$column['Column']['id']]['2']['username']."</td>";
				} else if (!isset($result[$column['Column']['id']]['1']) && !isset($result[$column['Column']['id']]['2'])) {
					//Noch gar kein Dienst wurde belegt
					
					//Oder es hat sich einfach noch niemand Eingetragen
					if ($column['Column']['obligated']) $classString = $classString = ($dateIsInFuture) ? $errorlink : $error;
					echo "<td colspan='2' id='".$key."_".$column['Column']['id']."' $classString></td>";
				}
							
						
			}
		}
?>
		</tr>
	<?php endforeach; ?>
</table>
</div>

<div id="wahlmenu" title="Bitte ausw&auml;hlen" style="text-align: center;">
	<br />
	<button id="eintragen" style="width:200px">Eintragen</button>
	<br />
	<button id="austragen" style="width:200px">Austragen</button>
	<div id="eintragenSwitch">Schicht:
		<input type="radio" id="radio1" name="radio" value="" checked="checked" />
		<label for="radio1">Ganz</label><input type="radio" id="radio2" name="radio" value="_1" />
		<label for="radio2">1. H</label><input type="radio" id="radio3" name="radio" value="_2" />
		<label for="radio3">2. H</label>
	</div>
</div>
